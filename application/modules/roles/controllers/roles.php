<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roles extends TNK_Controller {
		
	public function index(){
		$this->load->model('roles/roles_model','role');

		$result = $this->role->list_roles();
		
		$view = $this->load->view('roles/role_list',array('_roles' => $result), true);
		
		$this->add_block($view,self::CENTER_BLOCK);
		$this->generate_page();
	}
	
	public function dom(){
		//load the js
		$this->add_js('assets/js/Ajax_test.js');
		$this->add_js('assets/js/website.js');
		
		
		//add the script for the widget
		$this->add_script2('domain_creation_click_function2');

		$this->generate_page();
	}
	
	//page that lists all the domains
	public function domains(){
		$this->load->model('roles/roles_model','role');

		//load the js
		$this->add_js('assets/js/Ajax_test.js');
		$this->add_js('assets/js/website.js');
		
		//add css
		$this->add_css('assets/css/website.css');

		//load data
		$domains 		= $this->role->list_domains();
		//$dom_privileges	= $this->role->get_all_domain_privileges();
		
		//load views
		$domain_view 			= $this->load->view('roles/domain_list', array('_domains' => $domains),true);
		$new_domain_button		= $this->get_new_domain_widget();
		$view_domain_privileges	= $this->get_domain_privileges_widget();
		//$this->load->view('roles/add_privilege_to_user_widget',null,true);
		//Add the views to the page		
		$this->add_block($domain_view, self::CENTER_BLOCK);
		$this->add_block($new_domain_button,self::RIGHT_BLOCK);
		$this->add_block($view_domain_privileges,self::CENTER_BLOCK);
		

		//add the script for the widget
		$this->add_script2('domain_creation_click_function');

		$this->generate_page();
	}
	
	//Page with details on a single domain
	public function domain_details($domain_name){
		$this->load->model('roles/roles_model','role');
		
		//load the js
		$this->add_js('assets/js/Ajax_test.js');
		$this->add_js('assets/js/website.js');
		
		//add css
		$this->add_css('assets/css/website.css');
		
		//loading data
		$roles 		= $this->role->list_domain_roles($domain_name,false);
		$domainID	= $this->role->get_domain_id($domain_name);
		
		//loading the views
		$roles_view 		= $this->widget_get_domain_roles_list($roles);
		$new_role_button	= $this->get_new_role_widget($domainID);




		//Add views to the page
		$this->add_block($roles_view,self::CENTER_BLOCK);
		$this->add_block("<h3>Problem above</h3>");
		$this->add_block($new_role_button,self::CENTER_BLOCK);
		
		$this->add_script2('roles','role_creation_click_function');
		
		$this->generate_page();
	}
	
	public function widget_get_domain_roles_list($roles){
		return $this->load->view('roles/domain_roles_list',array('_roles' => $roles),true);	
	}
	
	//Display all privileges for all domains
	public function privileges(){
		$this->title('Privileges');
		//load the javascript
		$this->add_js('assets/js/Ajax_test.js');
		$this->add_js('assets/js/lodash.compat.js');
		//load user controller

		$context_id			= 'priv_arrays';
		//load data 
		//load views
		//add views to the page

		$this->generate_page();
	}

	public function widget_button_add_privilege($buttonID = 'addPrivileges',$userID,$contextID){
		$this->load->library('View_generator');
		
	
		$userID = is_object($userID)?$userID->id:'';
		
		//load scripts
		$this->add_script2('roles','add_privileges_click_function',array('_userID' => $userID,'_buttonID' => $buttonID,'_contextID' => $contextID)); //loading the js for attaching actions to the button.
		
		//initialize the data for the button that will send 
		//the ajax request based on the data from the table.
		$buttonInit = array('content'	=> 'Add Privileges'
							,'name'		=> 'buttonPrivileges'
							,'value'	=> 'justAbutton'
							,'class'	=> 'btn btn-success'
							,'id'		=> $buttonID);
		
		
		//get the html button
		return  $this->view_generator->generate_form_element($buttonInit,View_generator::BUTTON);
		
			
	}
	
	public function privilege_managment($username){	
		//load the javascript
		$this->add_js('assets/js/Ajax_test.js');
		$this->add_js('assets/js/lodash.compat.js');
		$this->load->model('users_model');
		$this->load->module('users');

		$context_id			= 'priv_arrays';
		$button_id			= 'addPrivilegeButton';
		$userData 	= $this->users_model->get_user(array('username' => $username),'username');
		$userID 	= $userData->id;
		//load views
		$userPrivileges		= $this->users->widget_user_privileges($username);
		$privileges_view	= $this->get_privileges_widget($context_id,$userID);
		$button				= $this->widget_button_add_privilege($button_id,$userID,$context_id);
		
		$this->add_block($privileges_view);
		$this->add_block($button);
		$this->add_block($userPrivileges,self::RIGHT_BLOCK);
		$this->add_block($userPrivileges,self::LEFT_BLOCK);
		$this->generate_page();	
	}
	
	
	//Page with details on a single role
	public function role_details($domain_name,$role_name){
		$this->load->model('roles/roles_model','role');
		//$privileges = $this->role->list_privileges_of_role($domainID,$role_name);
		$privileges = $this->role->list_privileges_of_role_by_name($domain_name,$role_name);
		
		$privileges_view 		= $this->load->view('roles/role_privilege_list',array('_privileges' => $privileges,'_domainName' => $domain_name),true);
		
		//Add views to the page
		$this->add_block($privileges_view,self::CENTER_BLOCK);
		
		$this->generate_page();
	}
	
	
	
	
	public function test(){
		echo "Dans test !<br/>";
		//load the role model
		$this->load->model('roles/roles_model','role');
		
		//$this->test_db();
		
	//load the views
		$block = "<h3> Hello!</h3>";
		echo $block;
	//add the content of the views to the page
		$this->add_block($block	,self::CENTER_BLOCK);
		
		
		//$this->add_block('<p>'.$this->role->test().'</p>');
		
	//Generate the html page
		$this->generate_page();
	}
/********************************************************************
 * 				Widgets
 *********************************************************************/
	//Button for creating a new domain
	public function get_new_domain_widget(){
		return $this->load->view('roles/create_domain_widget',null,true);		
	}

	//button for creating a new role
	public function get_new_role_widget($domainID){
		return $this->load->view('roles/create_role_widget',array('_domain_id' => $domainID),true);
	}

	//button for adding privileges to a user
	public function get_add_privilege_to_user_widget($data){
		return $this->load->view('roles/add_privilege_to_user_widget',$data,true);
		//return '<h3>test workaround</h3>';
	}

	//Here, we test the fact of generating html from the constroler, instead of
	//going through a view
	public function get_domain_privileges_widget($context_id =''){
		$this->load->model('roles/roles_model','role');
		$this->load->library('View_generator');
		
		$data	= $this->role->get_all_domain_privileges();
		
		//with this result, we'll get the sub array, so that we can display a result for each domain
		$sub_array = $this->view_generator->get_sub_arrays($data,array(1));
		//initialize the title for each sub array to display
		$titles	= $this->view_generator->initialize_array_title('',1,'Domain: ','');
		//Set the links, before passing them in generate arrays
		$prefix = base_url().'Roles/privileges';
		
		$links = $this->view_generator->create_row_link(null,2,array(2),$prefix);
				
		$html = '';
		foreach($sub_array as $row){
			$html .= $this->view_generator->generate_titled_array($titles,$row,array(1),$links);
		}
		return "<div id='$context_id'>$html</div>";
	}
	
	//Return a list of all the privileges, grouped by their domain
	public function get_privileges_widget($contextID,$userID){
		$this->load->model('roles/roles_model','role');
		$this->load->library('View_generator');
		//
		//$this->add_script("<script>var contextID = '$contextID';</script>");
		
		//load data
		$privileges = $this->role->get_all_domain_privileges();
		//get the sub array based one the domain (first column).
		$privileges_sub_array = $this->view_generator->get_sub_arrays($privileges,array(1));
		
		//initialize the title for each sub array to display
		$titles	= $this->view_generator->initialize_array_title(null,1,null,null);		
				
		//Prepare the additional array element to add in the html table
		$checkBox_config = array('name'			=> array(2)	//second field is the name of the privilege
								,'privilege'	=> array(2)
								,'domain'		=> array(1) //first field is the name of the domain
								,'domainID'		=> array(3)
								,'id'			=> array(2,1)
								,'userID'		=> $userID
								);
		
		$global_element_id = 'privileges_list';
		$formData 	= array();
		$formData[] = $this->view_generator->form_element_configuration(View_generator::CHECKBOX,$checkBox_config,'','');
		//Html content
		$html = '';
		foreach($privileges_sub_array as $row){
			$html .= $this->view_generator->generate_titled_array($titles,$row,null,null,null,$formData,'');
		}
		//we wrap the generated tables into a div
		return "<div id='$contextID'>$html</div>";
	}
	
	public function get_test(){
		return 'testok';
	}

	//function for routing ajax calls relative to domain/roles/privileges.
	public function ajax($function){
		$ajaxOperationOk = '0';

		//We load the model, so we can call the DB functions.
		$this->load->model('roles/roles_model','role');
			
		switch($function){			
			//We receive the ajax call for the creation of a new domain
			case 'create_domain' :				
				//We take the name and description of the new Domain
				$domainName			= $this->input->post('name');
				$domainDescription	= $this->input->post('description');
				
				//Create the new domain
				$ajaxOperationOk = $this->role->create_domain(array(Roles_model::domain_name => $domainName,Roles_model::domain_description => $domainDescription));
				
				//Send feedback on the creation of the domain (success/fail).
				echo $ajaxOperationOk;
				break;
			case 'update_domain': break;
			
			case 'delete_domain' : break;
			
			case 'create_role' :				
				//we take the name of the new role, and the id of the domain
				$roleName	= $this->input->post('name');
				$domainID	= $this->input->post('domainID');

				//create the new role
				$ajaxOperationOk	= $this->role->create_role(array(Roles_model::role_name =>$roleName,
																	Roles_model::role_domain_ref => $domainID));		
				
				//send feedback on the creation of the role(success/fail).
				echo $ajaxOperationOk;
				break;
			
			case 'delete_role' : break;
			
			case 'add_privilege_to_user' : 
				$data	= $this->input->post('data');
				
				$this->add_privilege_to_user($data);
				
				break;
			case 'create_privilege' :
				break;

			default: ;
		}
		
		//return $ajaxOperationOk;
	}
	
	//Call the roles.model to add privileges to the user
	private function add_privilege_to_user($data){
	//we arrive here through an ajax call	
		$this->load->model('roles/roles_model','role');
		
		
		$priv_array = array();
		//format array in order to add privileges
		foreach($data as $row){
			$domainID 	= isset($row['domainID'])?$row['domainID']:'';
			$privilege	= isset($row['privilege'])?$row['privilege']:'';
			$userID		= isset($row['userID'])?$row['userID']:'';
			
			$priv_array[] = array(Roles_model::user_privilege_user_ref 		=> $userID
								, Roles_model::user_privilege_domain_ref 	=> $domainID
								, Roles_model::user_privilege_privilege_ref => $privilege);
		}
		
		$this->role->add_multiple_privileges_to_user($priv_array,$userID);
	}
	
	public function test_db(){
		//test for domain creation : ok
		//$this->role->create_domain(array('name' => 'test_dammit2', 'description' => 'ça marchait, et là ça ne marche plus'));
		
		//test for domain update : ok
		//$this->role->update_domain2(7, array('name' => 'Test-updated-name', 'description' => 'This is an updated domain! Crazy!'));
		
		//test for physical deletion of domain : ok
		//$this->role->physical_delete_domain(6);
		
		//test for logical deletion : OK
		//$this->role->delete_domain(8);
		
		//Test for getting the roles of a domain : !!! KO
		//$this->role->list_users_on_domain(2);
		
		//Test for getting the roles of a domain : OK
		//$this->role->list_domain_roles(2);

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
		$test = $this->role->get_user_privileges(5);
		
		foreach($test as $row){
			print_r($row);
		}
		
		//Test for getting the privileges of a role
		//print_r($this->role->list_privileges_of_role(1));
	}
}


