<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Controller for the Lectures component of LMS.
*	@author Vuk Pejovic
*/
class lectures extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->TPL = array();
		$this->TPL['active'] = 2;
		$this->load->helper(array('form','directory'));
		$this->load->model('Lectures_model');
		$this->load->library('ion_auth');
	}
	
	/**
	*	Displays the list of subcategories with lecture components.
	*/
	public function index()
	{	
		$categories = $this->Lectures_model->getAllCategories();
		
		$this->TPL['canCreate'] = ($this->ion_auth->logged_in() && ($this->ion_auth->is_admin() || $this->ion_auth->is_provider()));
		
		foreach($categories as $category){
			$this->TPL['categories'][$category->id]['name'] = $category->name;
			$this->TPL['categories'][$category->id]['subcategories'] = $this->Lectures_model->getSubcategories($category->id);
		}
		$this->template->show('lectures',$this->TPL);
	}
	
	/**
	*	Displays all lectures from a subcategory.
	*	@param $id Subcategory ID
	*/
	public function view_lectures($id){
		$t = $this->Lectures_model->getSubcategoryNameById($id);
		$this->TPL['title'] = $t[0]->name;
		$this->TPL['lectures'] = $this->Lectures_model->getLecturesBySubcategory($id);
		
		$this->template->show('lectures_view',$this->TPL);
	}
	
	/**
	*	Creates a new lecture and saves it in the database.
	*/
	public function create_lecture(){
		$this->load->library('form_validation');
		// Only admins and teachers can perform this action
		if (!($this->ion_auth->logged_in() && ($this->ion_auth->is_admin() || $this->ion_auth->is_provider())))
		{
			redirect('home', 'refresh');
		}
		$this->form_validation->set_rules('title','Title is required.','required');
		$this->form_validation->set_rules('content','Content is required.','required');

		$this->TPL['success'] = false;
		if($this->form_validation->run() == true){
			$this->TPL['input_data'] = $this->input->post();
			
			$sub = $this->input->post('subcategories');
			$title= $this->input->post('title');
			$content = $this->input->post('content');
			$l = $this->Lectures_model->insertNewLecture($title,$sub,$content,$this->ion_auth->user()->row()->id);
			
			if(isset($l)) $this->TPL['success'] = true;
		}
		
		$subs = $this->Lectures_model->getAllSubcategories();
		foreach($subs as $sub){
			$this->TPL['subcategories'][$sub->id] = $sub->category_name." - ".$sub->name;
		}
		$this->template->show('lectures_create',$this->TPL);
	}
	/**
	*	Displays a specific lecture to the user.
	*	@param $id Lecture ID
	*/	
	public function view_lecture($id){

		$lecture = $this->Lectures_model->getLectureById($id);

		$this->TPL['lecture'] = $lecture[0];
		
		$this->template->show('lecture_view',$this->TPL);
	}
}

