<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Controller for the User component of LMS.
*	@author Vuk Pejovic
*/
class user extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->TPL = array();
		$this->TPL['active'] = 3;
		$this->load->helper(array('form','directory'));
		$this->load->model('Questions_model');
		$this->load->library('ion_auth');
		date_default_timezone_set('America/New_York');	
	}
	/**
	*	Displays the user page if the user is logged in.
	*/		
	public function index()
	{			
		if (!($this->ion_auth->logged_in()))
		{
			redirect('home', 'refresh');
		}
		
		$this->TPL['history'] = $this->Questions_model->getAnswerHistoryById($this->ion_auth->user()->row()->id);
		$this->template->show('user',$this->TPL);
	}
	/**
	*	Uploads and replaces the profile picture for the user.
	*/		
	public function change_profile_picture(){
		 $config = array('upload_path'     =>  'userimg', 
                         'allowed_types' =>     'gif|jpg|png'); 

        $this->load->library('upload', $config); 

        if (!$this->upload->do_upload()): 
            $this->TPL['uploadReturnMsg'] = array('error' => $this->upload->display_errors()); 
        else: 
			// Since storing images in database is a bad idea,
			// all the images get uploaded to userimg folder,
			// renamed to a unique ID,
			// and then a reference to that image is added to the user row.
			// Unique ID is prefixed with user's id for the sake of organization.
			$data = array('upload_data' => $this->upload->data());
            $file = $data['upload_data']['file_name'];
			$newName = uniqid($this->ion_auth->user()->row()->id);
			rename($config['upload_path'].'/'.$file,$config['upload_path'].'/'.$newName);
			$this->TPL['uploadReturnMsg'] = $this->ion_auth->change_user_picture($newName);
		endif;
		$this->TPL['history'] = $this->Questions_model->getAnswerHistoryById($this->ion_auth->user()->row()->id);
		
		$this->template->show('user',$this->TPL);
	}
	
	
}

