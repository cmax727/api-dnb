<?php

class UserHelper{
 
  public static function isLoggedIn(){
    	$ci			=	&get_instance();
      $userData	=	$ci->session->userdata('userData');
      $id = (isset($userData['userId'])) ? $userData['userId'] : 0;
      $user = UserItem::factory($id);
      return (!empty($user->id)) ? true : false;
  }
  
}