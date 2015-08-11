<?php if (!defined('BASEPATH')) exit('No direct script access allowed');  


/**
*	Model for the Admin component of LMS.
*	@author Vuk Pejovic
*/
class Admin_model extends CI_Model { 

    function __construct() { 
        parent::__construct(); 
         
    }       
    /**
	*	Retrieves all available categories.
	*/
    function getAllCategories() { 
        $rs = $this->db->get('cp_categories'); 
        return $rs->result();
    }  
    /**
	*	Retrieves all available subcategories.
	*/	
	function getAllSubcategories(){
		$rs = $this->db->select('t1.name as name, t1.id as id,t2.name as category_name')
				->from('cp_subcategories as t1')
				->join('cp_categories as t2','t1.category = t2.id','INNER')
				->get();
        return $rs->result();
	}
    /**
	*	Retrieves a specific category.
	*	@param $id Category ID
	*/	
	function getCategoryById($id){
		$rs = $this->db->select('*')
				->from('cp_categories')
				->where('id',$id)
				->get();
		return $rs->result();
	}
    /**
	*	Retrieves subcategories of a category.
	*	@param $category Category ID
	*/	
	function getSubcategories($category){
		$this->db->where('category',$category);
		$rs = $this->db->get('cp_subcategories');
		return $rs->result();
	}
    /**
	*	Retrieves a name of specific subcategory.
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
	*	Creates a new category.
	*	@param $name Category Name
	*/		
	function createNewCategory($name){
		$result = $this->db->insert('cp_categories',array('name'=>$name));
		if($result == false){
			$errNo   = $this->db->_error_number(); 
			$errMess = $this->db->_error_message(); 
			log_message("error", "Problem inserting to categories: ".$errMess." (".$errNo.")");  
		}
		return $this->db->insert_id();
	}
    /**
	*	Creates a new subcategory.
	*	@param $name Subcategory Name
	*	@param $category Category ID
	*/		
	function createNewSubcategory($name,$category){
		$result = $this->db->insert('cp_subcategories',array('name'=>$name,'category'=>$category));
		if($result == false){
			$errNo   = $this->db->_error_number(); 
			$errMess = $this->db->_error_message(); 
			log_message("error", "Problem inserting to subcategories: ".$errMess." (".$errNo.")");  
		}
		return $this->db->insert_id();
	}
	/**
	*	Deactivates a category
	*	@param $id Category ID
	*/
	function deactivateCategory($id){
		$data = array('active' => false);
		$result = $this->db->where('id',$id)
							->update('cp_categories',$data);
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		}
		$this->db->trans_commit();
		return TRUE;		
	}
	/**
	*	Activates a category
	*	@param $id Category ID
	*/
	function activateCategory($id){
		$data = array('active' => true);
		$result = $this->db->where('id',$id)
							->update('cp_categories',$data);
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		}
		$this->db->trans_commit();
		return TRUE;		
	}
	
		/**
	*	Deactivates a subcategory
	*	@param $id Subcategory ID
	*/
	function deactivateSubcategory($id){
		$data = array('active' => false);
		$result = $this->db->where('id',$id)
							->update('cp_subcategories',$data);
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		}
		$this->db->trans_commit();
		return TRUE;		
	}
	/**
	*	Activates a subcategory
	*	@param $id Subcategory ID
	*/
	function activateSubcategory($id){
		$data = array('active' => true);
		$result = $this->db->where('id',$id)
							->update('cp_subcategories',$data);
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		}
		$this->db->trans_commit();
		return TRUE;		
	}
     
}