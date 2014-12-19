<?php
  class company extends CI_Model {
/* we are going to use this getSome for example purpose */
    protected $_table    =    'company';  
    
    function writeCompanyInfo($params){
        $tbName = $this->db->dbprefix($this->_table);
        //check existence
        $sql = "select comp_id from $tbName where comp_id = ? ";
        $sql = 
        $query = $this->db->query($sql);
        
    }
    function getAccessToken($pgId) {
        $tbName = $this->db->dbprefix($this->_table);
        $sql = "select * from $tbName where pg_id = '$pgId'";

        $query = $this->db->query($sql);
        $row = $query->row();
        
        $tk = null;
        if ( !empty($row) )
            $tk = $row->pg_token;        
        /*$select = $this->db->select('fb_token')
            ->where('id', '1'); 
        $q = $select->get($this->_table); 
        $tk = $q->row();
        */
       
       return $tk;
    }
    
    function addToken($userId, $pgId, $pgToken){
        
        $tbName = $this->db->dbprefix($this->_table);
        $sql = "REPLACE INTO $tbName(user_id, pg_id, pg_token)  VALUES( ?,?,?) ";
        $param = array($userId, $pgId, $pgToken);
        try{
            $this->db->query($sql, $param);
        }catch(Exception $e){
            
        }
    }
}

