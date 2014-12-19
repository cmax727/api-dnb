<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

	public function login()
	{
    if(!UserHelper::isLoggedIn() && !empty($_POST)){
        $login     = addslashes(trim($_POST['login']));
        $password  = trim($_POST['password']);
        if($user  = $this->_checkLogin($login, $password)){
          $this->_setUserSession($user);
          redirect('admin/homepage');
        }
     }elseif(UserHelper::isLoggedIn()){
       redirect('admin/homepage');
     }else{
       $this->load->view('admin/login.tpl.php');
     }
	}
  
  private function _checkLogin($login = '', $password = ''){
   $user  = UserItem::factory()->getSingleByField('name', $login);
   return ($user->id != 0 && $user->password == $password) ? $user : false;
  }
  
  private function _setUserSession(UserItem $user){
    $userData = array('userId'=> $user->id, 'userName'=> $user->name);
    $this->session->set_userdata('userData', $userData);
  }
  
  public function logOut(){
    $this->session->set_userdata('userData', '');
    redirect(base_url());
  }
  
}

?>