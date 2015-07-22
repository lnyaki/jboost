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
		
		$this->load->model('roles/roles_model','role');
		
		//Test for domain creation : ok.
		//$this->role->create_domain(array('name' => 'Test-name3',  'description' => 'Check that default value for deleted is space'));
		
		//test for domain update : ok
		//$this->role->update_domain2(7, array('name' => 'Test-updated-name', 'description' => 'This is an updated domain! Crazy!'));
		
		//test for physical deletion of domain : ok
		//$this->role->physical_delete_domain(6);
		
		//test for logical deletion : OK
		//$this->role->delete_domain(8);
		
		//Test for getting the roles of a domain
		$this->role->list_users_on_domain(2);

	//load the views
		$block = "<h3> Hello!</h3>";
		
	//add the content of the views to the page
		$this->add_block($block	,self::CENTER_BLOCK);
		
		
		//$this->add_block('<p>'.$this->role->test().'</p>');
		
	//Generate the html page
		$this->generate_page();
	}
}


