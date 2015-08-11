<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  
/**
*	Model for the Lectures component of LMS.
*	@author Vuk Pejovic
*/
class Questions_model extends CI_Model { 

    function __construct() { 
        parent::__construct(); 
         
    }       
	/**
	*	Retrieves all available categories.
	*/  
    function getAllCategories() { 
        $rs = $this->db->where('active',true)->get('cp_categories'); 
        return $rs->result();
    }  
	/**
	*	Retrieves all possible subcategories.
	*/
	function getAllSubcategories(){
		$rs = $this->db->select('t1.name as name, t1.id as id,t2.name as category_name')
				->where('t1.active',true)
				->from('cp_subcategories as t1')
				->join('cp_categories as t2','t1.category = t2.id','INNER')
				->get();
        return $rs->result();
	}
	
	/**
	*	Retrieves all subcategories of a category.
	*	@param $category Category ID
	*/
	function getSubcategories($category){
		$this->db->where('category',$category)->where('active',true);
		$rs = $this->db->get('cp_subcategories');
		return $rs->result();
	}
	
	/**
	*	Retrieves subcategory name.
	*	@param $id Subcategory ID
	*/
	function getSubcategoryNameById($id){
		$rs = $this->db->select('name')
						->from('cp_subcategories')
						->where('id',$id)
						->get();
		return $rs->result();
	}
	
	/**
	*	Retrieves the question set title.
	*	@param $id Question Set ID
	*/
	function getQuizTitleById($id){
		$rs = $this->db->select('*')
						->from('cp_questionsets')
						->where('id',$id)
						->get();
		return $rs->result();
	}
	
	/**
	*	Retrieves all quizzes from a subcategory.
	*	@param $id Subcategory ID
	*/
	function getQuestionsBySubcategory($id){
		$rs = $this->db->select('*')
						->from('cp_questionsets')
						->where('subcategory',$id)
						->get();
		return $rs->result();
	}
	/**
	*	Retrieves the questions of a question set.
	*	@param $id Question Set ID
	*/
	function getQuestionsById($id){
		$rs = $this->db->select('*')
						->from('cp_questions')
						->where('questionset',$id)
						->get();
		return $rs->result();				
	}
	
	/**
	*	Retrieves a specific question.
	*	@param $id Question ID
	*/
	function getQuestionById($id){
		$rs = $this->db->select('*')
						->from('cp_questions')
						->where('id',$id)
						->get();
		return $rs->result();				
	}
	
	/**
	*	Retrieves answers for a question
	*	@param $id Question ID
	*/
	function getAnswersById($id){
		$rs = $this->db->select('*')
						->from('cp_answers')
						->where('questionid',$id)
						->get();
		return $rs->result();
	}
	
	/**
	*	Retrieves a specific answer.
	*	@param $id Answer ID
	*/
	function getAnswerById($id){
		$rs = $this->db->select('*')
				->from('cp_answers')
				->where('id',$id)
				->get();
		return $rs->result();
	}
	
	/**
	*	Retrieves the number of questions in a question set.
	*	@param $id Question Set ID
	*/
	function getNumberOfQuestions($id){
		$rs = $this->db->select('count(*) as count')
					->from('cp_questions')
					->where('questionset',$id)
					->get();
		return $rs->result();
	}
	
	/**
	*	Retrieves a specific question set, with its questions and answers.
	*	@param $id Question Set ID
	*/
	function getQuizById($id){
		$rs = $this->db->select('cp_questionsets.title as title, cp_questions.title as question, answer, correct, cp_questionsets.subcategory as subcategory,cp_answers.id as answerid,cp_questions.id as questionid,cp_questionsets.id as questionsetid')
			->from('cp_questionsets')
			->where('cp_questionsets.id',$id)
			->join('cp_questions','cp_questionsets.id=cp_questions.questionset','INNER')
			->join('cp_answers','cp_questions.id = cp_answers.questionid','INNER')
			->get();			
		return $rs->result();
	}
	
	/**
	*	Retrieves the answer history for a specific user.
	*	@param $id User ID
	*/
	function getAnswerHistoryById($id){
		$rs = $this->db->select("cp_questions.title as question,cp_questionsets.title as quiz,cp_answers.answer as answer, cp_answers.correct as correct,cp_answer_history.date_answered as date")
			->from("cp_answer_history")
			->join('cp_questions','cp_questions.id=questionid','INNER')
			->join('cp_questionsets','cp_questions.questionset=cp_questionsets.id','INNER')
			->join('cp_answers','cp_answer_history.answerid=cp_answers.id','INNER')
			->order_by('date_answered','DESC')
			->where('studentid',$id)
			->get();
		return $rs->result();
	}
	
	/**
	*	Creates a new Question Set.
	*	@param $title Question Set Title
	*	@param $subcategory Question Set Subcategory
	*	@param $creator Question Set Author
	*	@param $level Question Set Difficulty
	*/
	function insertNewQuestionSet($title,$subcategory,$creator,$level){
		$result = $this->db->insert('cp_questionsets',array('title'=>$title,'subcategory'=>$subcategory,'creator'=>$creator,'level'=>$level));
		if($result == false){
			$errNo   = $this->db->_error_number(); 
			$errMess = $this->db->_error_message(); 
			log_message("error", "Problem inserting to questionsets: ".$errMess." (".$errNo.")");  
		}
		return $this->db->insert_id();
	}
	
	/**
	*	Creates a new Question.
	*	@param $title Question Title
	*	@param $subcategory Question Subcategory
	*	@param $set Question Set ID
	*/
	function insertNewQuestion($title,$subcategory,$set){
		$result = $this->db->insert('cp_questions',array('title'=>$title,'subcategory'=>$subcategory,'questionset'=>$set));
		if($result == false){
			$errNo   = $this->db->_error_number(); 
			$errMess = $this->db->_error_message(); 
			log_message("error", "Problem inserting to questions: ".$errMess." (".$errNo.")");  
		}
		return $this->db->insert_id();
	}
	/**
	*	Creates a new answer.
	*	@param $text Answer Text
	*	@param $question Question ID
	*	@param $correct Is the answer correct
	*/
	function insertNewAnswer($text,$question,$correct){
		$result = $this->db->insert('cp_answers',array('answer'=>$text,'questionid'=>$question,'correct'=>$correct));
		if($result == false){
			$errNo   = $this->db->_error_number(); 
			$errMess = $this->db->_error_message(); 
			log_message("error", "Problem inserting to answers: ".$errMess." (".$errNo.")");  
		}
		return $this->db->insert_id();
	}
	
	/**
	*	Adds a new entry to user's answer history.
	*	@param $student_id User ID
	*	@param $question_id Question ID
	*	@param $answer_id Answer ID
	*/
	function insertNewAnswerHistory($student_id,$question_id,$answer_id){
		$result = $this->db->insert('cp_answer_history',array('studentid'=>$student_id,'questionid'=>$question_id,'answerid'=>$answer_id));
		if($result == false){
			$errNo   = $this->db->_error_number(); 
			$errMess = $this->db->_error_message(); 
			log_message("error", "Problem inserting to answer_history: ".$errMess." (".$errNo.")");  
		}
		return $this->db->insert_id();
	}
          
}