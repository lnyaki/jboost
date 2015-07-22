<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//class Roles_model extends CI_Model{
	class Roles_model extends TNK_Model{
	//Table names
	const roles_table			= 'security_role';
	const domain_table			= 'security_domain';
	const privilege_table		= 'security_privilege';
	
	//Domain Fields
	const domain_name 			= 'name';
	const domain_description	= 'description';
	
	//Role Fields
	
	
	
	//delete lines below, when sure that it has no impact.
	const main_table 		= 'roles01';
	const privileges_table	= 'roles01';
	const user_privileges	= 'roles02';

	//call modes
	public static $cm_01	= array('*');
	
	/******************************************************************************
	 *                       Domain functions
	 * ****************************************************************************/
	//Tested : ok
	//Function that creates a new domain (new entry in table security_domain).
	public function create_domain($data){		
		return $this->db->insert(self::domain_table,$data);
	}
	
	
	//Update of an existing domain
	public function update_domain($domainID,$data){
		//We check that we don't receive null data, or null domain ID.
		if($domainID == null){
			echo '[roles_model.update_domain]ERR : Trying to update domain with null DomainID.';
			return false;
		}
		
		if( $data == null){
			echo '[roles_model.update_domain]ERR : Trying to update domain with null data.';
			return false;
		}
		
		$name 			= '';
		$description 	= '';
		$data_is_set	= false;
		$update_values	= '';
		
		//if the name should be changed, we initialize $name and description before putting them in the update statement.
		if(isset($data[self::domain_name])){
			$update_values	= self::domain_name.' = '.$data[self::domain_name];
			$data_is_set	= true;
		}
		
		if(isset($data[self::domain_description])){
			if(!$data_is_set){
				$update_values 	=  self::domain_description.' = '.$data[self::domain_description];
			}
			else{
				$update_values .= ', '.self::domain_description.' = '.$data[self::domain_description];
			}
			
			$data_is_set 		= true;
		}
		
		
		//If the data should really be updated
		if($data_is_set){
			$sql = 'UPDATE '.self::domain_table.'set '.$update_values.' where id = ? ';	
		}
		//No data to update, we generate an error.
		else{
			echo '[roles_model.update_domain]ERR : Trying to update domain with empty data.';
			return false;
		}
		
		
	}
	
	//logical deletion of a domain
	public function delete_domain($domainID){
		
	}
	
	//list users with rights on this domain
	public function list_users_on_domain($domainID){
		
	}
	
	//list the roles active on this domain
	public function list_domain_roles($domainID){
		
	}
	
	/******************************************************************************
	 *                       Role functions
	 * ****************************************************************************/
	//create a new role (and linked privileges) for a domain
	public function create_role($domainID,$role_name,$privileges){
		
	}
	
	//update a role (modify name, linked privileges, etc)
	public function update_role($roleID, $data){
		
	}
	
	//logicial deletion of a role
	public function delete_role($roleID){
		
	}
	
	//Add a new role to a user
	public function add_role_to_user($roleID,$userID){
		
	}
	
	
	//Remove a role from a user
	public function remove_role_from_user($roleID,$userID){
		
	}
	
	//return the roles/privileges of a user.
	public function get_user_roles($userID){
	}



	//return the list of roles
	public function get_roles_list(){
		
		$sql	 = "SELECT * FROM ".self::roles_table;
		
		$roles	= array();
		
		$result	= $this->db->query($sql);
		
		foreach($result->result() as $res){
			array_push($roles,$res);
		} 
		
		return $roles;
	}
	
	/******************************************************************************
	 *                       Privilege functions
	 * ****************************************************************************/
	 //Add a single privilege to a user
	 public function add_privilege_to_user($privilegeID,$userID){
	 	
	 }
	 
	 //Remove a single privilege from a user
	 public function remove_privilege_from_user($privilegeID,$userID){
	 	
	 }
	 
	 //Logical deletion of a privilege (the roles must be corrected too)
	 public function delete_privilege($privilegeID){
	 	
	 }
	 
	 
	 
	//return the list of types of privilege (creation, validation, etc)
	public function get_privileges_list(){
		$sql	 = "SELECT * FROM ".self::privileges_table;
		
		$operations	= array();
		$fields		= array();
		
		$result	= $this->db->query($sql);
		
		foreach($result->result() as $res){
			array_push($operations,$res);
		} 
		
		//get the field names
		foreach ($result->list_fields() as $elt){
			array_push($fields,$elt);
		}
		
		
		return array($fields,$operations);
	}
	
	//return the privileges linked to a role.
	public function get_privileges($role){
		
	}
	
	public function create_privilege($privilege){
		
	}
	
	//For test purposes, can be deleted when tests are done.
	public function test(){
		//return $this->model_test();
		$this->generate_insert("test_table", array('field1' => 'value1', 'field2' => 'value2'));
		echo $this->db->last_query();
	}
}
	