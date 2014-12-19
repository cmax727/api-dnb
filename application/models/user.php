<?php
class User extends MY_Model{
	
	protected $_table	=	'users';
	
	public function __construct(){
		parent::__construct();	
	}
	
	public function select($alias = false){
		if (!$alias){
			$alias	=	'';
		}else{
			$alias	.=	'.';
		}
		return 	$this->db
					->select($alias.'id as id')
					->select($alias.'name as name')
					->select($alias.'password as password');
	}
	
}

class UserItem extends Item{
	
	public $id        = 0;
  public $name		  =	'';
	public $password	=	'';
	
	public function getModel(){
		return $this->getCI()->user;
	}
	
	static public function factory($id = false){
		return new UserItem($id);
	}
}