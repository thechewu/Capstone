<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Controller for the Questions component of LMS.
*	@author Vuk Pejovic
*/
class questions extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->TPL = array();
		$this->TPL['active'] = 1;
		$this->load->helper(array('form','directory'));
		$this->load->model('Questions_model');
		$this->load->library('ion_auth');
	}
	/**
	*	Displays the list of subcategories with quiz components.
	*/	
	public function index()
	{	
		$categories = $this->Questions_model->getAllCategories();
		
		// Determines whether the user is authorized to create a new quiz
		$this->TPL['canCreate'] = ($this->ion_auth->logged_in() && ($this->ion_auth->is_admin() || $this->ion_auth->is_provider()));
		
		foreach($categories as $category){
			$this->TPL['categories'][$category->id]['name'] = $category->name;
			$this->TPL['categories'][$category->id]['subcategories'] = $this->Questions_model->getSubcategories($category->id);
		}
		$this->template->show('questions',$this->TPL);
	}
	/**
	*	Displays all quizzes from a subcategory.
	*	@param $id Subcategory ID
	*/	
	public function view_questions($id){
		$t = $this->Questions_model->getSubcategoryNameById($id);
		$this->TPL['title'] = $t[0]->name;
		$this->TPL['questions'] = $this->Questions_model->getQuestionsBySubcategory($id);
		
		$this->template->show('questions_view',$this->TPL);
	}
	/**
	*	Creates a new quiz and saves it in the database.
	*/	
	public function create_question(){
		$this->load->library('form_validation');
		if (!($this->ion_auth->logged_in() && ($this->ion_auth->is_admin() || $this->ion_auth->is_provider())))
		{
			redirect('home', 'refresh');
		}
		$this->form_validation->set_rules('title','Title is required.','required');
		$this->form_validation->set_rules('questions[0][0]','Question is required.','required');
		$this->form_validation->set_rules('questions[0][1][0]','Question is required.','required');
		$this->form_validation->set_rules('questions[0][1][0]','Question is required.','required');
		$this->TPL['success'] = false;
		if($this->form_validation->run() == true){
			$this->TPL['input_data'] = $this->input->post();
			
			$sub = $this->input->post('subcategories');
			$title= $this->input->post('title');
			$level = $this->input->post('level');
			// Fun part!
			// First, a question set gets created.
			// Then, all the questions for the question set are added to the database.
			// Lastly, all answers are added for the respective questions.
			$set = $this->Questions_model->insertNewQuestionSet($title,$sub,$this->ion_auth->user()->row()->id,$level);
			
			foreach($this->input->post('questions') as $q){
				if(strlen(trim($q[0]))>0){
					$question = trim($q[0]);
					$question_id = $this->Questions_model->insertNewQuestion($question,$sub,$set);					
					for($i=0;$i<4;$i++){
						if(strlen(trim($q[1][$i]))>0){
							$answer = trim($q[1][$i]);
							$correct = isset($q[2][$i]);
							$answer_id = $this->Questions_model->insertNewAnswer($answer,$question_id,$correct);	
						}
					}
					
				}
			}
			$this->TPL['success'] = true;
		}
		
		$subs = $this->Questions_model->getAllSubcategories();
		
		foreach($subs as $sub) $this->TPL['subcategories'][$sub->id] = $sub->category_name." - ".$sub->name;
		
		for($i = 1;$i<=10;$i++) $this->TPL['levels'][$i]=$i;
		
		$this->template->show('questions_create',$this->TPL);
	}
	/**
	*	Displays a specific quiz to the user.
	*	@param $id Quiz ID
	*/		
	public function view_quiz($id){
		$this->load->library('form_validation');
		$title = $this->Questions_model->getQuizTitleById($id);
		$questions = $this->Questions_model->getQuestionsById($id);

		$answers = array();
		$sets = array();
		$set['a'] = array();
		foreach($questions as $q){
			$set['q'] = $q;
			$set['a'] = $this->Questions_model->getAnswersById($q->id);
			array_push($sets,$set);
		}
		$this->TPL['title'] = $title;
		$this->TPL['quizId'] = $id;
		$this->TPL['questions'] = $sets;
		
		$this->template->show('quiz_view',$this->TPL);
	}
	/**
	*	Submits the quiz and saves the result to user history.
	*	@param $id Quiz ID
	*/	
	public function submit_quiz($id){
	
		$answers = $this->input->post();
		$correct = 0;
		
		$numqs = $this->Questions_model->getNumberOfQuestions($id);
		if($this->ion_auth->logged_in()) $userid = $this->ion_auth->user()->row()->id;
		$i=0;
		foreach($answers as $key=>$value){
			if($key!="submit"){
				$answer = $this->Questions_model->getAnswerById($value);
				if($answer[0]->correct == TRUE){
					$correct++;
				}
				$i++;
				// Save the results only if the user is logged in
				if($this->ion_auth->logged_in()) $this->Questions_model->insertNewAnswerHistory($userid,$key,$value);
			}
		}
		
		// In case user's messed with form values and the numbers don't match,
		// they get a zero.
		// Stay in school, and don't hack my forms.
		if($numqs[0]->count != $i)	$correct = 0;
		

		$this->TPL['quizId'] = $id;
		$this->TPL['correct'] = $correct;
		$this->TPL['num'] = $numqs[0]->count;
		$this->TPL['data'] = $this->input->post();		
		
		$this->template->show('quiz_submit',$this->TPL);
	}	
	
	/**
	*	Returns a new question view.
	*	@param $data New Question Index
	*/
	public function create_new_question_string($data){
		$this->TPL['index'] = $data;
		return $this->load->view('new_question',$this->TPL);
	}
}

