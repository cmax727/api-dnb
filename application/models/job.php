<?php
class Job extends MY_Model{
	
	protected $_table	=	'jobs';
    

  
  public function __construct(){
		parent::__construct();	
	}
  
  public function select($alias = false, $limit = 5, $offset = 0){
		if (!$alias){
			$alias	=	'';
		}else{
			$alias	.=	'.';
		}
    
    
		return 	$this->db
					->select($alias.'id as id')
					->select($alias.'title as title')
					->select($alias.'day as day')
					->select($alias.'month as month')
					->select($alias.'year as year')
					->select($alias.'duration as duration')
					->select($alias.'link_to_apply as link_to_apply')
					->select($alias.'fan_page_id as fan_page_id')
					->select($alias.'description as description')
					->select($alias.'country_state as country_state')
					->select($alias.'image as image')
          ->select($alias.'rate as rate')
          ->select($alias.'rate as rate')
          ->order_by($alias.'id', "desc"); 
          ;
   }
   
   
   public function getLimitedAndFiltered($limit, $offset = 0, $filter = false){
     if($filter){
       $this->db->where('fan_page_id', $filter);
     }
     $res =  $this->select()
                  ->from($this->_table)
                  ->limit($limit, $offset)
                  ->get()
                  ->result();
     
     return JobItem::factory()->batchApply($res);
   }
   
   
   public function getCountByFilter($filter = false){
     if($filter){
       $this->db->where('fan_page_id', $filter);
     }
     return $this->select()
                  ->from($this->_table)
                  ->count_all_results();
   }
   
}


class JobItem extends Item{
	
	public $id        = 0;
  public $title		  =	'';
	public $day	=	0;
  public $month = 0;
  public $year = 0;
	public $duration	=	'';
	public $link_to_apply	=	'';
	public $fan_page_id	=	0;
  public $description = '';
  public $country_state = '';
  public $image = '';
  public $rate  = '';
	
	public function getModel(){
		return $this->getCI()->job;
	}

  public function getLimitedAndFiltered($limit, $offset = 0, $filter = false){
    return $this->getModel()->getLimitedAndFiltered($limit, $offset, $filter);
  }
  
  public function getCountByFilter($filter = false){
    return $this->getModel()->getCountByFilter($filter);
  }
  
  static public function factory($id = false){
		return new JobItem($id);
	}
}
  