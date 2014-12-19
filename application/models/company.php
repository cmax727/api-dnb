<?php
  class Company extends CI_Model {
/* we are going to use this getSome for example purpose */
    protected $_table    =    'company';  
    
    /**
    * exsistence check
    * 
    * @param mixed $compId
    */
    function isExist($compId){
        $tbName = $this->db->dbprefix($this->_table);
        $sql = "select 1 asx  from $tbName where com_id = '$compId'";
        
        $query = $this->db->query($sql);
        $rowCnt = $query->num_rows();
        if ( $rowCnt == 0 )
            return false;
        else
            return true;
    }
    
    /**
    * 
    * 
    * @param mixed $relation : (com_a => array(comb, comb, comb, ....))
    */
    function addRelation($relation){
        $tbName = $this->db->dbprefix("com_rival");
        $sql = "INSERT IGNORE INTO $tbName(com_a, com_b)  VALUES(?,?) ";
        foreach ( $relation as $coma=>$combList){
            foreach ( $combList as $comb){
                try{
                    $this->db->query($sql, array($coma, $comb));
                }catch(Exception $e){
                    
                }        
            }
        }
    }
    
    function addCompanyInfo($compData){
        $tbName = $this->db->dbprefix($this->_table);
        //check existence
        $sql = "replace into dnb_api.dnb_company( com_id,duns_num,Name,description,address,industry,executives,urls,yearFounded,parent_duns,parent_name,keyFinancials )
values( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ) ";
        
        $query = $this->db->query($sql, array(
            $compData['companyId'],
            $compData['duns'], 
            $compData['name'], 
            $compData['synopsis'], 
            json_encode($compData['locations']) , 
            json_encode($compData['industries']) , 
            json_encode($compData['topExecutives']['official']) , 
            $compData['primaryURLs']['primaryUrl'][0]['url'], 
            $compData['yearFounded'], 
            $compData['ultimateParentDuns'], 
            $compData['ultimateParentName'], 
            json_encode($compData['keyFinancials']), 
            )
        );
        
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

