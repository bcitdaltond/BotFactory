<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AboutController extends Application
{
	// Constructor
    function __construct()
    {
        parent::__construct();
    }

	/**
	 * Index Page for this About controller.
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

		$this->data['pagetitle'] = 'About ('. $role . ')';

		$this->data['pagebody'] = 'About/about';

		$this->data['logo'] = '/pix/icons/robot_logo.png';

		$this->render(); 
	}
}