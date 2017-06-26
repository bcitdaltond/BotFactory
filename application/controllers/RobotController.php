<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RobotController extends Application
{
    // Constructor 
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Index page for RobotController
     */
    public function index(){

        $role = $this->session->userdata('userrole');

        // checks the role and redirects to homepage if it's insufficient permissions
        if ($role == ROLE_GUEST || $role == ROLE_WORKER) redirect('/home');
        
        $this->data['pagetitle'] = 'Bot Factory - Robots ('. $role . ')';
        
        $this->data['pagebody'] = 'Robot/robots';

        $this->render();
    }

    /**
     * @param $which the id of the item that we are looking for
     */
    public function details($which){

        $role = $this->session->userdata('userrole');
        if ($role == ROLE_GUEST || $role == ROLE_WORKER) redirect('/home');

        // set all the parameters the page needed
        $this->data['pagetitle'] = 'BotFactory - Robot details ('. $role . ')';

        $this->data['pagebody'] = 'Robot/robots';

        $source = $this->robots->get($which);
        $this->data['type'] = $source->type;
        $this->data['topPardId'] = $source->topPardId;
        $this->data['torsoPartId'] = $source->torsoPartId;
        $this->data['bottomPartId'] = $source->bottomPartId;
        $this->data['cost'] = $source->cost;
        $this->data['date'] = $source->stamp;

        if($source->topPardId == $source->torsoPartId &&
            $source->torsoPartId== $source->bottomPartId){
            $this->render();
        }
        else{
            $this->data['pagebody'] = 'Robot/assRobot';
            $this->render();
        }

    }
}