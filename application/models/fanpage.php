<?php

class Fanpage extends MY_Model{
  
  protected $_table	=	'fan_pages';
  
  public function select($alias = false){
    if (!$alias){
			$alias	=	'';
		}else{
			$alias	.=	'.';
		}
		return 	$this->db
					->select($alias.'id as id')
					->select($alias.'name as name')
          ->select($alias.'url as url')
          ->order_by('name', 'asc')
          ;
  }
  
}

class FanpageItem extends Item{
  
  public $id = 0;
  public $name = '';
  public $url = '';
  
  
  public function getModel(){
		return $this->getCI()->fanpage;
	}

  static public function factory($id = false){
		return new FanpageItem($id);
	}
  
}