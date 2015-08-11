<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Controller for the Home component of LMS.
*	@author Vuk Pejovic
*/
class home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->TPL = array();
		$this->TPL['active'] = 0;
	}
	
	/**
	*	Redirects users to the homepage.
	*/
	public function index()
	{	
		$this->template->show('home',$this->TPL);
	}

}

