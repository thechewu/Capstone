<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
*	Controller for the IAS component of LMS.
*	@author Vuk Pejovic
*/
class ias extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->TPL = array();
		$this->TPL['active'] = 6;
		$this->load->helper(array('form','directory'));
		$this->load->model(array('Questions_model','Ias_model'));
		$this->load->library(array('ion_auth','session'));
	}
	/**
	*	Displays the list of subcategories available for IAS, from which user can select one and start the assessment.
	*/
	public function index()
	{	
		if (!($this->ion_auth->logged_in()))
		{
			redirect('home', 'refresh');
		}	
		$categories = $this->Questions_model->getAllCategories();
		foreach($categories as $category){
			$this->TPL['categories'][$category->id]['name'] = $category->name;
			$this->TPL['categories'][$category->id]['subcategories'] = $this->Questions_model->getSubcategories($category->id);
		}
		$this->template->show('ias_view',$this->TPL);
	}
	
	/**
	*	Starts a new assessment for the user in the specific subcategory, or continues an existing one.
	*	@param $sub_id Id of the subcategory for the assessment
	*/
	public function start_assessment($sub_id){
		$userid = $this->ion_auth->user()->row()->id;
		$existing = $this->Ias_model->getAssessmentById($userid,$sub_id);
		
		if($existing == FALSE){
			$this->Ias_model->insertNewAssessment($userid,$sub_id);
		}
		
		$this->load_next_question($sub_id);
	}
	
	/**
	*	Loads the next question for the user from the same subcategory, based on user's proficiency.
	*	@param $sub_id Id of the subcategory for the assessment
	*/
	function load_next_question($sub_id,$score = -1){
		$userid = $this->ion_auth->user()->row()->id;
		$level = $this->Ias_model->getAssessmentById($userid,$sub_id)->level;
		$level = floor($level);
		$nextQuestion = $this->Ias_model->getRandomQuestionSetByLevel($sub_id,$level);
		// No suitable question (max/min reached?)
		if($nextQuestion == FALSE){
			redirect('ias','refresh');
		}else{
			$nextQuestion = $nextQuestion->id;
		}
		
		$title = $this->Questions_model->getQuizTitleById($nextQuestion);
		$questions = $this->Questions_model->getQuestionsById($nextQuestion);

		$answers = array();
		$sets = array();
		$set['a'] = array();
		
		foreach($questions as $q){
			$set['q'] = $q;
			$set['a'] = $this->Questions_model->getAnswersById($q->id);
			array_push($sets,$set);
		}
		
		$this->TPL['title'] = $title;
		$this->TPL['quizId'] = $nextQuestion;
		$this->TPL['questions'] = $sets;
		if($score >= 0) $this->TPL['score'] = ($score*100).'%';
		
		$this->template->show('ias_quiz_view',$this->TPL);
	}
	
	/**
	*	Updates user's level based on the score on the quiz.
	*	@param $id Quiz id
	*/
	public function submit_quiz($id){
		$passingGrade = 0.6;
		$answers = $this->input->post();
		$correct = 0;
		
		$numqs = $this->Questions_model->getNumberOfQuestions($id);
		$userid = $this->ion_auth->user()->row()->id;
		
		$i=0;
		
		foreach($answers as $key=>$value){
			if($key!="submit"){
				$answer = $this->Questions_model->getAnswerById($value);
				if($answer[0]->correct == TRUE){
					$correct++;
				}
				$i++;
				$this->Questions_model->insertNewAnswerHistory($userid,$key,$value);
			}
		}
		
		if($numqs[0]->count != $i) $correct = 0;	
		
		$num = $numqs[0]->count;
		
		$quiz = $this->Questions_model->getQuizById($id);
		
		$sub_id = $quiz[0]->subcategory;
		
		$level = $this->Ias_model->getAssessmentById($userid,$sub_id)->level;
		
		$score = $correct/$num;

		$n = $this->Ias_model->getNumberOfQuestionsForSubcategoryAndLevel($sub_id,$level);
		$adjustment = ($score >= $passingGrade ? pow($score,7.0) : -(1.0/(max($score,0.1)))/10.0) /log(max(M_E,$n));

		$level = min(max(1.0,$level+$adjustment),$this->Ias_model->getMaxSubcategoryLevel($sub_id));
		
		$this->Ias_model->updateExistingAssessment($userid,$sub_id,$level);
		
		$this->load_next_question($sub_id, $score);
	}
}

