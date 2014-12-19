<?php
/**
 * 
 * MY_Model
 * @author Pyatopal
 *
 */

class MY_Model extends CI_Model{
	/**
	 * 
	 * Must be adjust for each child
	 * @$_table Table name
	 */
	protected $_table;
	
//	public function select($alias = false);
	
	public function __construct(){
		parent::__construct();
    $this->db->query('SET NAMES '.$this->db->escape_str("utf8"));
    $this->db->query('SET CHARACTER SET '.$this->db->escape_str("utf8"));
	}
	
	public function getById($object){
		$result = $this->select()
						->from($this->_table)
						->where('id', $object->id)
						->get()
						->row();
		
		return $object->apply($result);
	}
	
	public function getSingleByField($field, $value, $object){
		$result =	$this->select()
						 ->from($this->_table)
						 ->where($field, $value)
						 ->get()
						 ->row();
		return $object->apply($result);
	}
  
  public function getMultipleByField($field, $value, $object){
		$result =	$this->select()
						 ->from($this->_table)
						 ->where($field, $value)
						 ->get()
						 ->result();
		return $object->batchApply($result);
	}
  
  
  public function getMultipleByMultipleFields($feildsValuesArray, $object){
    foreach($feildsValuesArray as $key=>$value){
      $this->db->where($key,$value);
    }
    
    $result =	$this->select()
						 ->from($this->_table)
						 ->get()
						 ->result();
		return $object->batchApply($result);
  }
	
	public function save($object){
		$data	=	(array) $object;
		$vars	=	 get_object_vars($object);
		$savingData = array();
		foreach ($vars as $key=>$var){
			$savingData[$key]	=	$data[$key];			
		}
		if (!empty($savingData)){
			if (isset($savingData['id']) && !empty($savingData['id'])){
				$this->db->where('id', $savingData['id']);
				$this->db->update($this->_table, $savingData); 
			}else{
				$this->db->insert($this->_table, $savingData);
				$object->id 	=	$this->db->insert_id();
			}			
		}	
		return $object;
	}
	
	public function remove($object){
		$data	=	(array) $object;
		if (isset($data['id']) && !empty($data['id'])){
			$this->db->delete($this->_table, array('id' => $data['id'])); 
		}
	}
	
	public function getAll($object){
		$result =  $this->select()
						->from($this->_table)
						->get()
						->result();
		return $object->batchApply($result);		
	}
}

 class Item{
	public $id	=	0; 
	
	public function __construct($id = false){
		if($id){
			$this->id = $id;
			$this->getModel()->getById($this);
		}
	}
	
	public function save(){
		return $this->getModel()->save($this);
	}
	
	public function getAll(){
		return $this->getModel()->getAll($this);
	}
	
	public function getSingleByField($field, $value){
		return $this->getModel()->getSingleByField($field, $value, $this);
	}
  
  public function getMultipleByField($field, $value){
		return $this->getModel()->getMultipleByField($field, $value, $this);
	}
	
  public function getMultipleByMultipleFields($feildsValuesArray){
    return $this->getModel()->getMultipleByMultipleFields($feildsValuesArray, $this);
  }
  
	public function remove(){
		$this->getModel()->remove($this);
	}
	
	public function apply($data){
		if (is_object($data) || is_array($data)){
			$data	=	(array)$data;
			foreach ($data as $key=>$value){
				$classVars	=	array_keys(get_class_vars(get_class($this)));
				if (in_array($key, $classVars)){
					$this->$key	=	$data[$key];	
				}
			}
			return $this;
		}	
	}
	
	public function batchApply($dataInArray){
		$out = array();
		foreach ($dataInArray as $key => $data){
			$object	=	clone $this;
			if (is_object($data) || is_array($data)){
				$data	=	(array)$data;
				foreach ($data as $key=>$value){
					$classVars	=	array_keys(get_class_vars(get_class($this)));
					if (in_array($key, $classVars)){
						$object->$key	=	$data[$key];	
					}
				}
				$out[] 	=	$object;
			}
		}
		return $out;
	}
	
	public function getCI(){
		$ci = & get_instance();
		return $ci; 
	}

}
