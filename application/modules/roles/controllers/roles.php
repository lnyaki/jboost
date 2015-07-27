<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roles extends TNK_Controller {
		
	public function index(){
		$this->load->model('roles/roles_model','role');
		
		$result = $this->roles_model->get_roles_list();
		print_r($result);
		
		echo " <br/>";
		
		$result = $this->roles->get_privileges_list();
		print_r($result);
	}
	
	//page that lists all the domains
	public function domains(){
		$this->load->model('roles/roles_model','role');
		
		//load the js
		$this->add_js('assets/js/Ajax_test.js');
		
		//load data
		$domains = $this->role->list_domains();
		
		//load views
		$domain_view 		= $this->load->view('roles/domain_list', array('_domains' => $domains),true);
		$new_domain_button	= $this->get_new_domain_widget();
		
		//Add the views to the page		
		$this->add_block($domain_view, self::CENTER_BLOCK);
		$this->add_block($new_domain_button,self::RIGHT_BLOCK);
		
		
		$this->generate_page();
	}
	
	//Page with details on a single domain
	public function domain_details($domain_name){
		$this->load->model('roles/roles_model','role');
		
		$roles = $this->role->list_domain_roles($domain_name,false);
		
		$roles_view 		= $this->load->view('roles/domain_roles_list',array('_roles' => $roles),true);

		//Add views to the page
		$this->add_block($roles_view,self::CENTER_BLOCK);
		
		$this->generate_page();
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

	//Button for creating a new domain
	public function get_new_domain_widget(){
		return $this->load->view('roles/create_domain_widget',null,true);		
	}

	//function for routing ajax calls relative to domain/roles/privileges.
	public function ajax($function){
		echo "AJAX : ".$function;
		
		$ajaxOperationOk = false;
		
		switch($elt){
			//We receive the ajax call for the creation of a new domain
			case 'create_domain' :
				//We load the model, so we can call the DB functions.
				$this->load->model('roles/roles_model','role');
				
				//We take the name and description of the new Domain
				$domainName			= $this->input->post('domainName');
				$domainDescription	= $this->input->post('domainDescription');
				
				//Create the new domain
				$ajaxOperationOk = $this->role->create_domain(array(Roles_model::domain_name => $domainName,Roles_model::domain_description));
			
				break;
			case 'update_domain': break;
			
			case 'delete_domain' : break;
			
			case 'create_role' : break;
			
			case 'delete_role' : break;
			default: ;
		}
		
		return $ajaxOperationOk;
	}

	public function test_db(){
		//test for domain update : ok
		//$this->role->update_domain2(7, array('name' => 'Test-updated-name', 'description' => 'This is an updated domain! Crazy!'));
		
		//test for physical deletion of domain : ok
		//$this->role->physical_delete_domain(6);
		
		//test for logical deletion : OK
		//$this->role->delete_domain(8);
		
		//Test for getting the roles of a domain : !!! KO
		//$this->role->list_users_on_domain(2);
		
		//Test for getting the roles of a domain : OK
		$this->role->list_domain_roles(2);

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
		
		//Test for getting the privilege of a role : OK
		//$this->role->get_role_privileges(1);
		
		//Test for adding multiple privileges to a user at the same time : OK
		/*
		$data = array();
		array_push($data,array(Roles_model::user_privilege_user_ref 		=> '5',
								Roles_model::user_privilege_domain_ref 		=> '2',
								Roles_model::user_privilege_privilege_ref	=> 'submit')
				);
				
		array_push($data,array(Roles_model::user_privilege_user_ref 		=> '5',
								Roles_model::user_privilege_domain_ref 		=> '2',
								Roles_model::user_privilege_privilege_ref	=> 'consult')
				);
		
		array_push($data,array(Roles_model::user_privilege_user_ref 		=> '5',
								Roles_model::user_privilege_domain_ref 		=> '2',
								Roles_model::user_privilege_privilege_ref	=> 'create')
				);

		$this->role->add_multiple_privileges_to_user($data);
		*/
		
		//Test the addition of role (and therefore, privileges) to a user : OK
		//s$this->role->add_role_to_user(3,5);
		
		//Test for getting the privilege of a user
		//$test = $this->role->get_user_privilege(5);
		//print_r($test);
	}
}


