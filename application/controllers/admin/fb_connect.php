<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fb_connect extends MY_Controller {
 

  public function __construct() {
    parent::__construct();
    
    $this->checkLogged();
    //$this->load->model('fbtoken'); //this is autoloaded module
    require_once (APPPATH.'libraries/facebook/facebook.php');
  }
  
  
  public function index(){
    $this->load->view('admin/fb_connect/index.tpl.php');
    
  }
  
  public function load_facebook_api(){
          // Create our Application instance.
     include (APPPATH.'config/fb_config.php');      
    $facebook = new Facebook(array(
      'appId'  => '462254307141500',
      'secret' => '780ccd5a0051edc50451a5544ed5c107',
      'cookie' => true,
    ));

	/*$facebook = new Facebook(array(
      'appId'  => $fbconfig['appid'],
      'secret' => $fbconfig['secret'],
      'cookie' => true,
    ));*/

    //Facebook Authentication part
    $user       = $facebook->getUser();
    // We may or may not have this data based 
    // on whether the user is logged in.
    // If we have a $user id here, it means we know 
    // the user is logged into
    // Facebook, but we don’t know if the access token is valid. An access
    // token is invalid if the user logged out of Facebook.
           
    //rif people are not authorized then  this code will run
    $tkTable = new Fbtoken();   
     if (!$user) {
        // If you want to authenticate the user by redirecting them to the authentication URL then run this code
        //echo "<script type='text/javascript'>top.location.href = '$loginUrl';";
        // if you dont want people to redirect and want to run the pop up then here is the example
        //include_once 'index.php';
        
        //redirect('admin/fb_connect');
        //return $this->index();
        
         echo "not auth";
         }
    else
    {   try {
        $user_info = $facebook->api('/me');
        if ($user_info) {
                              $tkTable = new Fbtoken();
            
                              try {
                                $userPages= $facebook->api("/$user/accounts");
                                $records = count($userPages['data']);
                                
                                for ($i = 0; $i < $records; $i++)
                                    {
                                    $category=$userPages['data'][$i]['category'];
                                    
                                    if ( $category == "Application")    
                                        continue;
                                    
                                    $name= $userPages['data'][$i]['name'];
                                    $id=$userPages['data'][$i]['id'];
                                    $pageId=$id;
                                    try{
                                        
                                        //$page_info = $facebook->api("/$pageId?fields=access_token");
                                        //$page_token=$page_info['access_token']; 
                                        $page_token =  $userPages['data'][$i]['access_token'];
                                        //echo "Token of page with ID=" .$pageId. " = " . $page_token . "<br/>";
                                        echo "<b>{$name}</b> <=> $pageId <=> $page_token </br>";
                                        $tkTable->addToken($user, $pageId, $page_token);
                                    }catch(Exception $erx){
                                        $c = 10;
                                    }
                                    
                                    }
                                    
                            } 
                              catch (FacebookApiException $e) 
                              {
                                $this->show_array($e);
                                $user = null;
                              }
                    
         }
        } catch (FacebookApiException $e) {
            echo $e->getTraceAsString();
            exit;
            //include_once 'homepage.php';
            //User is not logged in
            //echo "not loged in";
        }
        
        $this->load->view('admin/fb_connect/fb_connect.tpl.php');
        
    }
 

      
  }
  
  private function show_array($d) {
        echo '<pre>';
        print_r($d);
        echo '</pre>';
  }
 
}
