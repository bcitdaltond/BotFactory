<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ManageController extends Application
{
    // Constructor
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/
     *    - or -
     *        http://example.com/about
     *
     * map to /Manage/index
     */
    public function index()
    {
        $cellsForRobots = array();
        
        $role = $this->session->userdata('userrole');

        $this->data['pagetitle'] = 'Manage (' . $role . ')';

        // checks the role and redirects to homepage if it's insufficient permissions
        if ($role != ROLE_BOSS) redirect('/home');

        // hides the message if there is no success/faliure message
        $this->session->userdata('message', null);
        $this->session->userdata('message_buy', null);
        $this->session->userdata('message_reboot', null);

        // sets the message to a success/faliure message
        $this->data['message'] = $this->session->userdata('message');
        $this->data['message_buy'] = $this->session->userdata('message_buy');
        $this->data['message_reboot'] = $this->session->userdata('message_reboot');

        $robots = $this->robots->all();

        //use the parser to build a robot
        foreach ($robots as $robot) {
            if ($robot->topPardId == $robot->torsoPartId &&
                $robot->torsoPartId == $robot->bottomPartId
            ) {
                $cellsForRobots[] = $this->parser->parse('Manage/_singleRobot', (array)$robot, true);
            } else {
                $cellsForRobots[] = $this->parser->parse('Manage/_singleAssRobot', (array)$robot, true);
            }
        }

        // create a html table to display the robot
        $this->load->library('table');
        $template = array(
            'table_open' => '<table class="theTable">',
            'cell_start' => '<td class="justOne">',
            'table_close' => '</table>'
        );

        // set the parser configure and parameters
        $this->table->set_template($template);

        $this->table->set_caption('Assembled Robots');
        if (!empty($cellsForRobots)) {
            $rows = $this->table->make_columns($cellsForRobots, 3);
            $this->data['tableRobots'] = $this->table->generate($rows);
        } else {
            $this->data['tableRobots'] = "<h3 style='text-align: center'>No Robots</h3>";
        }

        $this->data['pagebody'] = 'Manage/manage';

        $this->session->set_userdata('referred_from', current_url());

        $this->render();
    }

    /**
     * register for getting a token
     */
    public function registerme()
    {
        $this->data['pagebody'] = 'Manage/manage';

        $password = $this->input->post('password');

        $response = "Error";

        // save the password to password.txt
        if (!ctype_space($password)) {
            $passwordFile = fopen("password.txt", "w") or die("Unable to open file!");
            fwrite($passwordFile, $password);
            fclose($passwordFile);
            $response = file_get_contents("https://umbrella.jlparry.com/work/registerme/apple/" . $password);
        }

        $response = explode(" ", $response);

        if ($response[0] == "Ok") {
            $this->session->set_userdata('message', "Successfully Registered!");
            
            //get the token and store it into database
            $token = $response[1];
            $db_token = $this->properties->create();
            $property = $this->properties->all();
            
            //if no token
            if(sizeof($property) == 0){
                $db_token->token = $token;
                $this->properties->add($db_token);
            }else{
                $update = array(
                    'id' => $property[0]->id,
                    'token' => $token
                );
                $this->properties->update($update);
            }
            $referred_from = $this->session->userdata('referred_from');
            redirect($referred_from, 'refresh');
        } else {
            $referred_from = $this->session->userdata('referred_from');
            $this->session->set_userdata('message', "Oops: Bad password!");
            redirect($referred_from, 'refresh');
        }
    }

    /**
     * reboot the plant
     */
    public function rebootme()
    {
        $this->data['pagebody'] = 'Manage/manage';
        $this->session->set_userdata('message_reboot', null);

        $current_token = $this->properties->head(1);
        $token = $current_token[0]->token;

        $response = file_get_contents("http://umbrella.jlparry.com/work/rebootme/apple?key=" . $token);
        if ($token == null) { // if no existing token
            $this->session->set_userdata('message_reboot', "Please register first!");
            $referred_from = $this->session->userdata('referred_from');
            redirect($referred_from, 'refresh');
        }

        if ($response == "Oops: I don't recognize you!") { // if password/token is incorrect 
            $this->session->set_userdata('message_reboot', "Token expired, Please register first!");
            $referred_from = $this->session->userdata('referred_from');
            redirect($referred_from, 'refresh');
        } else { // if password/token is correct, clears the password file and database.
            unlink("password.txt");
            $this->clearDatabase();
            $referred_from = $this->session->userdata('referred_from');
            $this->session->set_userdata('message_reboot', "Successfully rebooted!");

            redirect($referred_from, 'refresh');
        }
    }

    /**
     * clear the whole database
     */
    public function clearDatabase()
    {
        $this->db->cache_delete_all();
        foreach ($this->history->all() as $history){
            $this->history->delete($history->transactionID);
        }

        foreach ($this->parts->all() as $part){
            $this->parts->delete($part->partID);
        }

        foreach ($this->robots->all() as $robot){
            $this->robot->delete($robot->robotID);
        }

        foreach ($this->properties->all() as $property){
            $this->properties->delete($property->id);
        }
    }

    /*
     * ship the robot
     */
    public function ship()
    {
        if (isset($_POST['robotCheck']) && !empty($_POST['robotCheck'])) {
            $robotsID = $this->input->post('robotCheck');
            $robots = array();
            foreach ($robotsID as $id) {
                //get selected robots
                $robots[] = $this->robots->get($id);
            }
            $url = 'http://umbrella.jlparry.com/work/buymybot';
            $properties = $this->properties->tail();
            if (sizeof($properties) == 0) {
                // if empty (e.g. no token)
                redirect(base_url("/register"));
                return;
            } else{
                $current_token = $this->properties->head(1);
                $token = $current_token[0]->token;
            }
            if (file_get_contents("http://umbrella.jlparry.com/info/whoami?key=" . $token) != "apple"){
                redirect(base_url("/register"));
                return;
            }

            /*
             * loop to sell the robots
             */
            foreach ($robots as $robot) {
                $shipUrl = $url . "/" . $robot->topCode . "/" . $robot->torsoCode . "/" . $robot->bottomCode . "?key=" . $token;
                $response = file_get_contents($shipUrl);
                $responseArray = explode(" ", $response);
                
                // success to sell
                if ($responseArray[0] == "Ok") {
                    $amount = $responseArray[1];

                    //delete robots on database
                    $this->robots->delete($robot->robotID);

                    //add to history
                    $addHistory = array(
                        'category' => 'Shipped',
                        'description' => 'Sale a robot',
                        'amount' => $amount,
                    );
                    $this->history->add($addHistory);
                } else {
                    // if i do this it will show the message?
                    $this->showMessage(implode(" ", $responseArray));
                    
                    //$this->errorMessage(implode(" ", $responseArray));
                    return;
                }
            }
            $this->showMessage($responseArray[0]);
        } else {
            $this->showMessage("Please select a robot.");
        }
    }

    /*
    *   Custom function to display messages
    */
    public function showMessage($message)
    {
        $role = $this->session->userdata('userrole');

        if ($role == ROLE_GUEST || $role == ROLE_WORKER || $role == ROLE_SUPERVISOR) redirect('/home');
        switch ($role) {
            case ROLE_GUEST:
                $this->data['menubuttons'] = '_buttonsguest';
                break;
            case ROLE_WORKER:
                $this->data['menubuttons'] = '_buttonsworker';
                break;
            case ROLE_SUPERVISOR:
                $this->data['menubuttons'] = '_buttonssupervisor';
                break;
            case ROLE_BOSS:
                $this->data['menubuttons'] = '_buttonsboss';
                break;
        }
        $this->data['pagetitle'] = 'Assembly - Result (' . $role . ')';
        $this->data['pagebody'] = 'Manage/result';
        $this->data['message'] = $message;
        $this->render();
    }
}