<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {


	public function index()
	{
		$this->template->show('home');
	}
	
	public function printCtlr() 
    {      
        highlight_file('application/controllers/home.php'); 
        exit;  
    } 
     
    public function printView() 
    {      
        highlight_file('application/views/home.php'); 
        exit;  
    } 
     
    public function printHelper() 
    {      
        highlight_file('application/helpers/asset_helper.php'); 
        exit;  
    } 
     
    public function printLibrary() 
    {      
        highlight_file('application/libraries/Template.php'); 
        exit;  
    } 
}

