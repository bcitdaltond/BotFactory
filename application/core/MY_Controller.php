<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2016, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller
{

	/**
	 * Constructor.
	 * Establish view parameters & load common helpers
	 */

	function __construct()
	{
		parent::__construct();

		//  Set basic view parameters
		$this->data = array ();
		$this->data['pagetitle'] = 'Bot Factory';
		$this->data['ci_version'] = (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>'.CI_VERSION.'</strong>' : '';
	}

	/**
	 * Render this page
	 */
	function render($template = 'template')
	{
		$this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

		$role = $this->session->userdata('userrole');
		if ($role == null){
			$this->session->set_userdata('userrole',ROLE_GUEST);
			$this->data['menubuttons'] = '_buttonsguest';

		} else{
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
			
		}
		$this->data['navbuttons'] = $this->parser->parse($this->data['menubuttons'], $this->data, true);
		
		$this->parser->parse('template', $this->data);
	}

}