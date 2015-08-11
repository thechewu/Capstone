<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  
/**
*	Model for the IAS component of LMS.
*	@author Vuk Pejovic
*/
class Ias_model extends CI_Model { 

    function __construct() { 
        parent::__construct(); 
         
    }       
    /**
	*	Retrieves assessment state for the user in the specific subcategory.
	*	@param $userid User ID
	*	@param $subid Subcategory ID	
	*/
	function getAssessmentById($userid,$subid){
		$result = $this->db->select('*')
						->from('cp_assessment')
						->where('studentid',$userid)
						->where('subcategory',$subid)
						->get();
		$a = $result->result();
		// Return false if it doesn't exist
		if(!empty($a)){
			return $a[0];
		}else{
			return false;
		}
	}
    /**
	*	Retrieves a random question from the subcategory, of the specific level.
	*	@param $subid Subcategory ID	
	*	@param $level Quiz Level	
	*/	
	function getRandomQuestionSetByLevel($subid,$level){
		$result = $this->db->select('*')
							->from('cp_questionsets')
							->where('subcategory',$subid)
							->where('level',$level)
							->order_by('id','RANDOM')
							->get();
		$a = $result->result();
		// If the wanted question doesn't exist, return false for easier checking
		if(!empty($a)){
			return $a[0];
		}else{
			return false;
		}
	}
	/**
	*	Retrieves the maximum level of a subcategory.
	*	@param $subid Subcategory ID
	*/
	function getMaxSubcategoryLevel($subid){
		$result = $this->db->select('max(level) as max')
						->from('cp_questionsets')
						->where('subcategory',$subid)
						->get();
		$a = $result->result();	
		return $a[0]->max;
	}
	/**
	*	Returns the number of questions of specific subcategory and level.
	*	@param $subid Subcategory ID
	*	@param $level Question Set Level
	*/
	function getNumberOfQuestionsForSubcategoryAndLevel($subid,$level){
		$result = $this->db->select('count(*) as count')
						->from('cp_questionsets')
						->where('subcategory',$subid)
						->where('level',$level)
						->get();
		$a = $result->result();	
		return $a[0]->count;
	}
	
	/**
	*	Inserts new assessment state for the user in the specific subcategory.
	*	@param $userid User ID
	*	@param $subid Subcategory ID
	*/
	function insertNewAssessment($userid,$subid){
		$result = $this->db->insert('cp_assessment',array('studentid'=>$userid,'subcategory'=>$subid,'level'=>'1'));
		if($result == false){
			$errNo   = $this->db->_error_number(); 
			$errMess = $this->db->_error_message(); 
			log_message("error", "Problem inserting to assessment: ".$errMess." (".$errNo.")");  
		}
		return $this->db->insert_id();
	}
	/**
	*	Updates an existing assessment.
	*	@param $userid User ID
	*	@param $subid Subcategory ID
	*	@param $level New Level
	*/	
	function updateExistingAssessment($userid,$subid,$level){
		$data = array('level' => $level);
		$result = $this->db->where('studentid',$userid)
							->where('subcategory',$subid)
							->update('cp_assessment',$data);
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		}
		$this->db->trans_commit();
		return TRUE;					
	}
    	
}