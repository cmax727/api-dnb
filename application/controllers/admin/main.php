<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MY_Controller {
 

  public function __construct() {
    parent::__construct();
    
    $this->checkLogged();
    $this->load->model('job');
    $this->load->model('fanpage');
    $this->cssjsloader->link_js('jquery/jquery.validate.min');
    $this->cssjsloader->link_js('admin/main');
  }
  
  
  public function index(){
    if (isset($_GET['result']) && $_GET['result'] == 'success_added'){
      ErrorHelper::addMessage('Successfully Added.');
    }elseif (isset($_GET['result']) && $_GET['result'] == 'success_edit'){
      ErrorHelper::addMessage('Successfully Edited.');  
    }elseif (isset($_GET['result']) && $_GET['result'] == 'error'){
      ErrorHelper::add('Sorry, an error ocurs. Please try again.');
    }
    $fan_pages  =  FanpageItem::factory()->getAll();
    $jobs = JobItem::factory()->getLimitedAndFiltered(5, 0);  
    $count = (JobItem::factory()->getCountByFilter())/5;
    $this->load->view('admin/helpers/header.tpl.php');
    $this->load->view('admin/dashboard.tpl.php', array('fan_pages' => $fan_pages, 'jobs' => $jobs, 'count' => $count));
    $this->load->view('admin/helpers/footer.tpl.php');
  }
  
  public function postjobform($id = false){
    $fan_pages = FanpageItem::factory()->getAll();
    $job = JobItem::factory($id);
    $this->load->view('admin/helpers/header.tpl.php');
    $this->load->view('admin/postjob.tpl.php', array('fan_pages' => $fan_pages, 'job' => $job));
    $this->load->view('admin/helpers/footer.tpl.php');
  
  }
  
  public function savejob(){
    $id  = $this->input->post('id');
    /*$url = $_POST['link_to_apply'];
    if ( ! preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) {
      $this->postjobform();
     return;   
    }*/
    
    if(!empty($id)){
      $this->_editExistedJob($id);
      redirect(base_url() . 'admin/main?result=success_edit');
    }else{
      $job = $this->_saveJob(); 
      
      require_once (APPPATH.'libraries/facebook/facebook.php');
      include (APPPATH.'config/fb_config.php');      
      require_once (APPPATH.'libraries/class.html2text.inc');
      //============= facebook post
      $tkTb = new Fbtoken();
      $pageId= $_POST['fan_page_id'];
      $access_token= $tkTb->getAccessToken($pageId);

      $facebook = new Facebook(array(
          'appId'  => $fbconfig['appid'],
          'secret' => $fbconfig['secret'],
          'cookie' => true,
          ));

    $linkUrl = "www.facebook.com/profile.php?id={$pageId}&sk=app_379258938775123&app_data={$job->id}";
    $imgUrl = "http://fb.productionnotices.com/images/img.png";
    if ( $job->image){
        $imgUrl = "http://fb.productionnotices.com/images/jobs/{$job->id}/{$job->image}";    
    }
    
    try {
            $h2t = new html2text($job->description);
            $description = $h2t->get_text();
            $attachment = array(
              'message' => "",
              'link' => $linkUrl,
              'name' => $job->title,
              'picture' => $imgUrl,
              'description' => $description,
              'caption' => "www.productionnotices.com",
              'access_token' => $access_token
              );
              
               /*$attachmenta = array(
                  'message' => "Hello all,How are you?",
                  'link' => "http://link.com/xxdfe/link-section",
                  'name' => "This is a name",
                  'picture' => $imgUrl,
                  'description' => "and this is a descript",
                  'caption' => "hello caption",
                  'access_token' => $access_token
                  );*/
            
        $post_id= $facebook->api("/" . $pageId . "/feed", 'post', $attachment);
        //echo $post_id . "if you see 1 on it means tab/app has been added to the fan page";
        
      } catch (FacebookApiException $e) {
         echo '<pre>';
        print_r($e);
        echo '</pre>';
        $user = null;
      }
      
      redirect(base_url() . 'admin/main?result=success_added');
     }
  }
  
  private function _saveJob(){
    $job = JobItem::factory()->apply($_POST);
    $job->image = $_FILES["image"]["name"];
    $job->save();
    $this->_savePictures($job);
    
    return $job;
    
  }
  
  private function _editExistedJob($id){
    $oldJob = JobItem::factory($id);
    $newJob = JobItem::factory()->apply($_POST);
    $newJob->image = $_FILES["image"]["name"];
    if($oldJob->image != $newJob->image && !empty($newJob->image)){
      $this->_removePicture($oldJob);
      $this->_savePictures($newJob);
    }else{
      $newJob->image = $oldJob->image;
    }
    $newJob->save();
  }
  
  
  private function _savePictures(JobItem $job){
    $jobId  = $job->id;
    $jobImageDir  = 'images/jobs/' . $jobId;
    if (!is_dir($jobImageDir)){
          mkdir($jobImageDir, 0777, true);
          chmod($jobImageDir, 0777);
    }
    if(is_uploaded_file($_FILES["image"]["tmp_name"])){
      $fullPath = $jobImageDir . '/' . $_FILES["image"]["name"];
      move_uploaded_file($_FILES["image"]["tmp_name"], '/srv/www/fb.productionnotices.com/public_html/' . $fullPath);
      //move_uploaded_file($_FILES["image"]["tmp_name"], 'w:/wamp/htroot/' . $fullPath);
    }
  }
  
  private function _removePicture(JobItem $job){
    $jobId = $job->id;
    $imageName = $job->image;
    $path  = 'images/jobs/' . $jobId . '/' . $imageName;
    if(is_file($path)){
      return unlink($path);
    }
  }


  public function ajax_getPages(){
    $curpage    = $_POST['curpage'];
    $direction  = $_POST['direction'];
    $filter     = $_POST['filter'];
    
    $count = ceil(JobItem::factory()->getCountByFilter($filter)/5);
    $fan_pages = FanpageItem::factory()->getAll();
    switch($direction){
      case 'first' :
        $offset = 0;
        $number = 1;
        break;
      case 'last' :
        $offset = ($count - 1) * 5; 
        $number = $count;
        break;
      case '-10' :
        $number = $curpage;
        $number--;
        if($number <= 0){
          $number = 1;
        }
        $offset = ($number - 1) * 5; 
        break;
      case '+10' :
        $number = $curpage;
        $number++;
        if($number >= $count){
          $number = $count;
        }
        $offset = ($number - 1) * 5; 
        break;
    }
    $jobs = JobItem::factory()->getLimitedAndFiltered(5, $offset, $filter);  
    $html = $this->load->view('admin/helpers/item.tpl.php', array('jobs' => $jobs, 'fan_pages' => $fan_pages), true);
    
    $result['html']    = $html;
    $result['count']   = $count;
    $result['current'] = $number;
    
    echo json_encode($result);
  }
  
  
  public function ajax_delItem(){
    $ids = $this->input->post('ids');
    $ids = explode(',', $ids);
    foreach ($ids as $id){
      JobItem::factory($id)->remove();
      $this->_removeDir($id);
    }
  }
  
  private function _removeDir($id){
    $jobImageDir  = 'images/jobs/' . $id . '/';
    foreach(glob($jobImageDir.'*.*') as $v){
      if(is_file($v)){
        unlink($v);
      }
    }
    if(is_dir($jobImageDir)){
      rmdir($jobImageDir);
    }
  }
 
}
