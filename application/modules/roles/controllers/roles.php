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
		//load the role model
		$this->load->model('roles/roles_model','role');
		
		$this->test_db();
		
	//load the views
		$block = "<h3> Hello!</h3>";
		
	//add the content of the views to the page
		$this->add_block($block	,self::CENTER_BLOCK);
		
		
		//$this->add_block('<p>'.$this->role->test().'</p>');
		
	//Generate the html page
		$this->generate_page();
	}

	public function test_db(){
		//test for domain update : ok
		//$this->role->update_domain2(7, array('name' => 'Test-updated-name', 'description' => 'This is an updated domain! Crazy!'));
		
		//test for physical deletion of domain : ok
		//$this->role->physical_delete_domain(6);
		
		//test for logical deletion : OK
		//$this->role->delete_domain(8);
		
		//Test for getting the roles of a domain : oK
		//$this->role->list_users_on_domain(2);

		//Test for creating a new role : OK
		//$this->role->create_role(array( 'name' => 'Test_role','domain_ref' => '2' ));
		
		//Test for updating roles : OK
		//$this->role->update_role(3,array('name' => 'Updated-Role'));
		
		//Test for logical deletion : OK
		//$this->role->delete_role(3);
		
		//Test for addition of privilege : ok
		//$this->role->add_privilege_to_user('comment',2,5);
		
		//Test the deletion of a privilege : OK
		//$this->role->remove_privilege_from_user('comment',5);
		
		//Test update and logical deletion of privilege : OK
		//$this->role->delete_privilege('comment');
		//$this->role->update_privilege('comment',array('deleted' => ' '));
		
		//Test for getting the list of all possible privileges : OK
		//$this->role->get_privileges_list();
		
		//Test the creation of new privilege : OK
		//$this->role->create_privilege('Test_Privilege_Hello!');
		
	}
}


