<?php

class MY_Controller extends CI_Controller{
  
  public function __construct() {
    parent::__construct();
  }
  
  public function checkLogged(){
		if (!UserHelper::isLoggedIn()){
			redirect('admin');
		}		
	}
  
}