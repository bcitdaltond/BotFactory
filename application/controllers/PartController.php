<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PartController extends Application
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
     *        http://example.com/parts
     *
     */
    public function index()
    {
        $role = $this->session->userdata('userrole');
        
        // checks the role and redirects to homepage if it's insufficient permissions
        if ($role == ROLE_GUEST) redirect('/home');

        $this->data['pagetitle'] = 'BotFactory - Parts (' . $role . ')';

        $this->data['pagebody'] = 'Parts/parts_page';

        $source = $this->parts->all();

        $this->data['parts'] = $source;

        // set page to return to
        $this->session->set_userdata('referred_from', current_url());

        $this->render();
    }

    /**
     * @param $id the id we are using to allocate the item
     * set data to the model
     */
    public function details($id)
    {
        $role = $this->session->userdata('userrole');
        if ($role == ROLE_GUEST) redirect('/home');

        $this->data['pagetitle'] = 'BotFactory - Part Details (' . $role . ')';

        $this->data['pagebody'] = 'Parts/part_details';

        $source = $this->parts->get($id);

        $this->data['partID'] = $source->partID;

        $this->data['model'] = $source->model;

        $this->data['piece'] = $source->piece;

        $this->data['plant'] = $source->plant;

        $this->data['line'] = $source->line;

        $this->data['CA_code'] = $source->CA_code;

        $this->data['stamp'] = $source->stamp;

        $this->render();
    }

    /**
     * Builds parts
     */
    public function build()
    {
        //$properties = $this->properties->tail();
        if (sizeof($this->properties->all()) != 0) {
            $current_token = $this->properties->head(1);
            $token = $current_token[0]->token;
        } else {
            redirect(base_url("/register"));
            return;
        }

        $parts_response = file_get_contents("http://umbrella.jlparry.com/work/mybuilds?key=" . $token);
        $built_parts = json_decode($parts_response, true);

        $response = explode(' ', $parts_response);

        if(file_get_contents("http://umbrella.jlparry.com/info/whoami?key=" . $token) != "apple") {
            redirect(base_url("/register"));
            return;
        } elseif($response[0] == "[]"){
            echo "<b>Not enough parts to retrieve or need register</b>";
            $referred_from = $this->session->userdata('referred_from');
            redirect($referred_from, 'refresh');
        }
        else {
            $size = sizeof($built_parts);
            foreach ($built_parts as $part) {
                $p = $this->parts->create();

                $p->CA_code = $part['id'];
                $p->model = $part['model'];
                $p->piece = $part['piece'];
                $p->plant = $part['plant'];
                $p->stamp = $part['stamp'];
                
                // get line
                if (preg_match("/^[a-lA-L]$/", $part['model'])) {
                    $p->line = "household";
                } else if (preg_match("/^[m-vM-V]$/", $part['model'])) {
                    $p->line = "butler";
                } else {
                    $p->line = "companion";
                }
                $p->isAvailable = 1;

                // insert into database
                $this->parts->add($p);
            }
            
            $record = array('category' => 'Build', 'description' => 'Built ' . $size . ' parts');

            // Update history table
            $this->history->add($record);
            $referred_from = $this->session->userdata('referred_from');
            redirect($referred_from, 'refresh');
        }
        // return to original page
    }

    /**
     * Buys a box of parts
     */
    public function buy()
    {
        if (sizeof($this->properties->all()) != 0) {
            $current_token = $this->properties->head(1);
            $token = $current_token[0]->token;
        } else {
            redirect(base_url("/register"));
            return;
        }

        // if empty (e.g. no token)
        if (file_get_contents("http://umbrella.jlparry.com/info/whoami?key=" . $token) != "apple"){
            redirect(base_url("/register")); // ask the user to grab api key (token)
            return;
        }

        $parts_response = file_get_contents("http://umbrella.jlparry.com/work/buybox?key=" . $token);

        $box_parts = json_decode($parts_response, true);

        if (is_array($box_parts)) {
            foreach ($box_parts as $part) {
                $p = $this->parts->create();

                $p->CA_code = $part['id'];
                $p->model = $part['model'];
                $p->piece = $part['piece'];
                $p->plant = $part['plant'];
                $p->stamp = $part['stamp'];
                $p->piece = $part['piece'];
                
                // get line
                if (preg_match("/^[a-lA-L]$/", $part['model'])) {
                    $p->line = "household";
                } else if (preg_match("/^[m-vM-V]$/", $part['model'])) {
                    $p->line = "butler";
                } else {
                    $p->line = "companion";
                }
                $p->isAvailable = 1;

                // insert into database
                $this->parts->add($p);
            }
            // Add history record
            $record = array('category' => 'Buy Box', 'description' => 'Buy a Box ', 'amount' => -100);
            // update history table
            $this->history->add($record);
        }

        // return to original page
        $referred_from = $this->session->userdata('referred_from');
        redirect($referred_from, 'refresh');
    }

}