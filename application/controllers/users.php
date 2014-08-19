<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends TNK_Controller {
	
	function index(){
		echo "<div> ffs </div>";
	}
	
	function profile($username){
		$data['content'] = "<div> Hello, user profile $username</div>";
		$this->create_page($data);
	}
	
	function login(){
		$data['content'] = $this->load->view('users/login.php',null,true);
		$this->create_page($data);
	}
	
	function register(){
		$data['content']	= $this->load->view('users/register.php',null,true);
		$this->create_page($data);
	}
	
	function registerlogin(){
		$data['content']	= $this->load->view('users/register_login.php',null,true);
		$this->create_page($data);
	}
}