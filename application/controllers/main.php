<?php

class Main extends MY_Controller{
  
  private $filter = '';
  private $api;
  private $treeE = array();
  public function __construct() {
    parent::__construct();
    $this->api = new dnbapi_rest();
    $this->load->model('company');
    
    //$this->cssjsloader->link_js('jquery/jquery.validate.min');
    
  }
 
  public function index($offset =  0){
       
      $keyword = $_REQUEST['keyword'];
      if ( isset($keyword))
        $data = $this->api->FindCompanyByKeywordSimple($keyword);
      
      $viewParam = array("keyword" => $keyword, "data" =>json_decode($data,  true  ) );
      $this->load->view('index.tpl.php' , $viewParam );
  }
  
  public function processCompany(){
      $compId = $_REQUEST['compid'];

      $modelCompany = new Company();
      $modelCompany->isExist($compId);

      $cc = $this->api->GetCompanyDetail($compId);
      
      $company = $this->api->toJson($cc);

      $relation = array();
      $cycle = array();
      $tree = array("companyId"=>$company['companyId'], 
            "companyName"=>$company['name']
        );
        
      $this->treeE = $tree;
      
      $this->_searchCompetitors($this->treeE, $cycle, $relation , 3);
      /*$cms = file_get_contents(__DIR__ ."/a.txt");
      $this->treeE = json_decode($cms, TRUE);
      $this->load->view('processcompany.tpl.php' , array("data" =>$this->treeE));
      return;
      */
      //------------- data synchronizing with Database
      // relation
      $modelCompany->addRelation($relation);
      // company
      foreach ( $cycle as $cid){
        if (!$modelCompany->isExist($cid)){
            $compData = $this->api->toJson( $this->api->GetCompanyDetail($cid) );
            if ( $compData == null)
                continue;
            $modelCompany->addCompanyInfo($compData);
        }
      }
      
      
      $this->load->view('processcompany.tpl.php' , array("data" =>$this->treeE ));
      return;
      
  }
  

 
  /**
  * innser search algorithm
  * 
  * @param mixed $compid
  * @param mixed $cycleCheck  array type (id, name, competitors)
  * @param mixed $compTree    array type
  * @param mixed $dept
  * @param mixed $maxDepth
  */
  function _searchCompetitors(&$compTree, &$cycleCheck, &$relation, $maxDepth = 3, $curDept = 0){
      if ( $curDept >= $maxDepth)
        return;
        
      $cc = $this->api->FindCompanyCompetitors($compTree['companyId'], true);
      $cc = preg_replace('/("\w+"):([\d\.]+)/', '\\1:"\\2"', $cc);
      $data = json_decode($cc, true);
      
      $copytCycleCheck = $cycleCheck;
      $relItems = array();
      foreach ($data['competitor'] as $com){
          //$subTree = array("companyId"=>$com['companyId'],
//            "name"=>$com["companyName"]
//            );
          $subTree = $com;  
          $relItems[] = $com['companyId'];
          $compTree['competitors'][] = $subTree;    
            
          if ( in_array($com['companyId'], $cycleCheck))
            continue;
          $cycleCheck[] = $com['companyId'];
      }
      $relation[$compTree['companyId']] = $relItems;
      // recursive    
      foreach ($compTree['competitors'] as $idx=>&$subTree ){
        if ( in_array($subTree['companyId'], $copytCycleCheck))
            continue;
        $this->_searchCompetitors($subTree, $cycleCheck, $relation, $maxDepth, $curDept+1);  
      }
  }
 
 function x(){
      $this->treeE;
 }
  
}