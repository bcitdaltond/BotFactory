<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AboutController extends Application
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
	 * 		http://example.com/about
	 *
	 * map to /About/index
	 */
	public function index()
	{
	    // set all the data parameters
		$role = $this->session->userdata('userrole');

		$this->data['pagetitle'] = 'BotFactory - About ('. $role . ')';

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

		$this->data['pagebody'] = 'About/about';

		$this->data['logo'] = '/pix/icons/robot_logo.png';

		$this->render(); 
	}
}