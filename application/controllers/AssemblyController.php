<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AssemblyController extends Application
{
    // Constructor
    function __construct()
    {
        parent::__construct();
    }

    /**
     * the main page of assembly page
     */
    public function index()
    {
        $top = array();
        $torso = array();
        $bottom = array();

        /**
         * set roles
         */
        $role = $this->session->userdata('userrole');

        // checks the role and redirects to homepage if it's insufficient permissions
        if ($role == ROLE_GUEST || $role == ROLE_WORKER) redirect('/home');

        $this->data['pagetitle'] = 'Assembly (' . $role . ')';

        $this->data['pagebody'] = 'Assembly/assembly';

        $parts = array();

        /**
         * display available parts
         */
        foreach ($this->parts->all() as $part) {
            if ($part->isAvailable == 1) {
                $parts[] = $part;
            }
        }
        
        //assembly the single parts tp a parser
        foreach ($parts as $part) {
            if ($part->piece == 1) {
                $top[] = $this->parser->parse('Assembly/_singlePart', (array)$part, true);
            } else if ($part->piece == 2) {
                $torso[] = $this->parser->parse('Assembly/_singlePart', (array)$part, true);
            } else if ($part->piece == 3) {
                $bottom[] = $this->parser->parse('Assembly/_singlePart', (array)$part, true);
            }
        }

        //create a html table to display the robot
        $this->load->library('table');
        $template = array(
            'table_open' => '<table class="theTable">',
            'cell_start' => '<td class="justOne">',
            'table_close' => '</table>'
        );

        //set the parser configure and parameters
        $this->table->set_template($template);
        $this->table->set_caption('Top Part');
        if (!empty($top)) {
            $rows = $this->table->make_columns($top, 3);
            $this->data['tableTop'] = $this->table->generate($rows);
        } else {
            $this->data['tableTop'] = "<h3 style='text-align: center'>No Top Parts</h3>";
        }
        $this->table->set_caption('Torso Part');
        if (!empty($torso)) {
            $rows = $this->table->make_columns($torso, 3);
            $this->data['tableTorso'] = $this->table->generate($rows);
        } else {
            $this->data['tableTorso'] = "<h3 style='text-align: center'>No Torso Parts</h3>";
        }
        $this->table->set_caption('Bottom Part');
        if (!empty($bottom)) {
            $rows = $this->table->make_columns($bottom, 3);
            $this->data['tableBottom'] = $this->table->generate($rows);
        } else {
            $this->data['tableBottom'] = "<h3 style='text-align: center'>No Bottom Parts</h3>";
        }

        $this->render();
    }

    /*
     * assembly or return parts
     */
    public function assemblyOrReturn()
    {
        $role = $this->session->userdata('userrole');
        if ($role == ROLE_GUEST || $role == ROLE_WORKER) redirect('/home');

        $partsAssembly = array();
        $partsReturn = array();
        if (isset($_POST['assembly']) && !empty($_POST['assembly'])) {
            $parts = array();
            $partsAssembly = $this->input->post('partCheck');
            //get parts
            if (!empty($partsAssembly)) {
                foreach ($partsAssembly as $part) {
                    $parts[] = $this->parts->get($part);
                }
            } else {
                $this->errorMessage("Nothing Selected");
                return;
            }

            $this->updatePart($parts, 0);

            // validate for number of parts
            if (sizeof($parts) != 3) {
                $this->errorMessage("Have to select 3 parts");
                $this->updatePart($parts, 1);
            } //validate three different pieces of parts
            elseif ($parts[0]->piece != 1 || $parts[1]->piece != 2 || $parts[2]->piece != 3) {
                $this->errorMessage("Have to select 3 piece in each top torso and bottom");
                $this->updatePart($parts, 1);
            } //no error
            else {
                $type = "";
                //get type of the robot
                if ($parts[0]->model == $parts[1]->model &&
                    $parts[2]->model == $parts[1]->model &&
                    ($parts[0]->model == 'a' || $parts[0]->model == 'b' ||
                        $parts[0]->model == 'c')
                ) {
                    $type = "household";
                } elseif ($parts[0]->model == $parts[1]->model &&
                    $parts[2]->model == $parts[1]->model &&
                    ($parts[0]->model == 'm' || $parts[0]->model == 'r')
                ) {
                    $type = "butler";
                } elseif ($parts[0]->model == $parts[1]->model &&
                    $parts[2]->model == $parts[1]->model &&
                    $parts[0]->model == 'w'
                ) {
                    $type = "companion";
                } else {
                    $type = "motley";
                }
                //add robot to database
                $robot = array(
                    'topPardId' => $parts[0]->model,
                    'torsoPartId' => $parts[1]->model,
                    'bottomPartId' => $parts[2]->model,
                    'type' => $type,
                    'cost' => 30,
                    'topCode' => $parts[0]->CA_code,
                    'torsoCode' => $parts[1]->CA_code,
                    'bottomCode' => $parts[2]->CA_code,
                );
                $this->robots->add($robot);

                //add record to history table
                foreach ($parts as $part) {
                    $addHistory = array(
                        'category' => 'Consuming',
                        'description' => 'assembly robots',
                        'amount' => 0,
                    );
                    $this->history->add($addHistory);
                }
                $this->errorMessage("Build Successful");
            }

            // return the parts
        } else if (isset($_POST['return']) && !empty($_POST['return'])) {
            $parts = array();
            $partsReturn = $this->input->post('partCheck');
            $url = 'http://umbrella.jlparry.com/work/recycle';


            $property = $this->properties->all();
            // if empty (e.g. no token)
            if (sizeof($property) != 0) {
                $token = $property[0]->token;
                if (file_get_contents("http://umbrella.jlparry.com/info/whoami?key=" . $token) != "apple") {
                    redirect(base_url("/register"));
                    return;
                }
            }else{
                redirect(base_url("/register"));
                return;
            }

            // if the token doesn't work
            if (!empty($partsReturn)) {
                foreach ($partsReturn as $part) {
                    $parts[] = $this->parts->get($part);
                }
            } else {
                $this->errorMessage("Select at least one part to return");
                return;
            }

            //get parts selected
            foreach ($parts as $part) {
                $returnUrl = $url . "/" . $part->CA_code . "?key=" . $token;
                $response = file_get_contents($returnUrl);
                $responseArray = explode(" ", $response);
                if ($responseArray[0] == "Ok") {
                    $amount = $responseArray[1];
                    $updatePart = array(
                        'partID' => $part->partID,
                        'isAvailable' => 0
                    );
                    $this->parts->update($updatePart);

                    $addHistory = array(
                        'category' => 'Recycle',
                        'description' => 'recycle parts',
                        'amount' => $amount,
                    );
                    $this->history->add($addHistory);

                } else {
                    $this->errorMessage(implode(" ", $responseArray));
                }
            }
            $this->errorMessage("Successful Returned");
        }
    }

    /**
     * message helper class to show messages
     * @param $message the message to show
     */
    public function errorMessage($message)
    {
        $role = $this->session->userdata('userrole');
        if ($role == ROLE_GUEST || $role == ROLE_WORKER) redirect('/home');

        $this->data['pagetitle'] = 'Assembly - Result (' . $role . ')';

        $this->data['error'] = $message;
        $this->data['pagebody'] = 'Assembly/result';
        $this->render();
    }

    /**
     * update the parts table
     * @param $parts the parts need to update
     * @param $available to set isAvailable to 0 or 1
     */
    public function updatePart($parts, $available)
    {
        foreach ($parts as $part) {
            $updatePart = array(
                'partID' => $part->partID,
                'isAvailable' => $available
            );
            $this->parts->update($updatePart);
        }
    }
}