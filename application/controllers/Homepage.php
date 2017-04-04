<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends Application
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
	 * 		http://example.com/
	 * 	- or -
	 * 		http://example.com/home
	 *
	 * map to /Homepage/index
	 */
	public function index()
	{
		$role = $this->session->userdata('userrole');
        
        // sets to guest role if no role is set
        if($role == null){
            $this->session->set_userdata('userrole', ROLE_GUEST);
        }

		$this->data['pagetitle'] = 'Apple BotFactory - Homepage ('. $role . ')';
		
		$this->data['pagebody'] = 'homepage' ;

        // get all the parameters that the dashboard need
		$parts = $this->parts->size();
		$robots = $this->robots->size();
		$spent = $this->history->getSpent();
		$earned = $this->history->getEarned();
		$total = 2000 + $earned - $spent;
		$data = array('parts' => $parts, 'robots' => $robots, 'spent' => $spent , 'earned' => $earned, 'total' => $total);
        
        $this->data = array_merge($this->data, $data);

		$this->render(); 
	}
}
