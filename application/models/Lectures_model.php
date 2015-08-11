<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  
/**
*	Model for the Lectures component of LMS.
*	@author Vuk Pejovic
*/
class Lectures_model extends CI_Model { 

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
	*	Retrieves all available subcategories.
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
	*	Retrieves the name of the subcategory.
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
	*	Retrieves all lectures from a subcategory.
	*	@param $id Subcategory ID
	*/
	function getLecturesBySubcategory($id){
		$rs = $this->db->select('*')
						->from('cp_lectures')
						->where('subcategory',$id)
						->get();
		return $rs->result();
	}
	/**
	*	Retrieves a specific lecture.
	*	@param $id Lecture ID
	*/
	function getLectureById($id){
		$rs = $this->db->select('*')
						->from('cp_lectures')
						->where('id',$id)
						->get();
		return $rs->result();
	}
	/**
	*	Creates a new lecture.
	*	@param $title Lecture title
	*	@param $subcategory Subcategory of the lecture
	*	@param $content	Lecture content
	*	@param $creator Lecture author
	*/
	function insertNewLecture($title,$subcategory,$content,$creator){
		$result = $this->db->insert('cp_lectures',array('title'=>$title,'subcategory'=>$subcategory,'content'=>$content,'creator'=>$creator));
		if($result == false){
			$errNo   = $this->db->_error_number(); 
			$errMess = $this->db->_error_message(); 
			log_message("error", "Problem inserting to questions: ".$errMess." (".$errNo.")");  
		}
		return $this->db->insert_id();
	}
	
	
     
}