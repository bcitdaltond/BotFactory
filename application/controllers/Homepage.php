<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends Application
{
    function __construct()
    {
        parent::__construct();
    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/
	 * 	- or -
	 * 		http://example.com/homepage
	 *
	 * map to /Homepage/index
	 */
	public function index()
	{
		$role = $this->session->userdata('userrole');
        if($role == null){
            $this->session->set_userdata('userrole',ROLE_GUEST);
        }
	    //set page title and view
		$this->data['pagetitle'] = 'Apple BotFactory - Homepage ('. $role . ')';


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
		
		$this->data['pagebody'] = 'homepage' ;

        // get all the parameters the dashboard need
		$parts = $this->parts->size();
		$robots = $this->robots->size();
		$spent = $this->history->getSpent();
		$earned = $this->history->getEarned();
		$data = array('parts' => $parts, 'robots' => $robots, 'spent' => $spent , 'earned' => $earned);
        
        $this->data = array_merge($this->data, $data);

		$this->render(); 
	}

}
