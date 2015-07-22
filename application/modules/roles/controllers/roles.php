<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roles extends TNK_Controller {
		
	public function index(){
		$this->load->model('roles_model');
		
		$result = $this->roles_model->get_roles_list();
		print_r($result);
		
		echo " <br/>";
		
		$result = $this->roles_model->get_privileges_list();
		print_r($result);
	}
	
	public function test(){
		
		//Test for domain creation : ok.
		$this->role->create_domain2(array('name' => 'Test-name2',  'description' => 'This is a domain for test purpose(test 2)'));
		
		
	//load the views
		$block = "<h3> Hello!</h3>";
		
	//add the content of the views to the page
		$this->add_block($block	,self::CENTER_BLOCK);
		
		$this->load->model('roles/roles_model','role');
		
		//$this->add_block('<p>'.$this->role->test().'</p>');
		
	//Generate the html page
		$this->generate_page();
	}
}


