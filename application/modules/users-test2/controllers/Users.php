<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 //this is for test purpose. It can be deleted later
class Users extends MX_Controller {
 
    public function index()
    {
    	echo "hello guys : users";
        //$this->load->view('users_view');
    }
	
	public function login(){
		echo "Hello world : login";	
	}
}