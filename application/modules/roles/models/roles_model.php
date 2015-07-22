<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//class Roles_model extends CI_Model{
	class Roles_model extends TNK_Model{
	//Table names
	const roles_table			= 'security_role';
	const domain_table			= 'security_domain';
	const privilege_table		= 'security_privilege';
	
	//Domain Fields
	const domain_id				= 'id';
	const domain_name 			= 'name';
	const domain_description	= 'description';
	const domain_deleted		= 'deleted';
	
	//Role Fields
	const role_name				= 'name';
	const role_domain_ref		= 'domain_ref';
	
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
		$this->db->where(self::domain_id,$domainID);
		return $this->db->update(self::domain_table,$data);
	}
	
	
	//logical deletion of a domain
	public function delete_domain($domainID){
		$this->update_domain($domainID,array(self::domain_deleted =>'Y'));
	}
	
	//physical delete
	public function physical_delete_domain($domainID){
		return $this->db->delete(self::domain_table, array(self::domain_id => $domainID));
	}
	
	//list users with rights on this domain
	public function list_users_on_domain($domainID){
	
	}
	
	//list the roles active on this domain
	public function list_domain_roles($domainID){
		//column aliases
		$domain_name_alias	= 'domain';
		$role_name_alias	= 'role';
		
		//crafting the query
		$this->db->select("$domain_name_alias.".self::domain_name." as $domain_name_alias,$role_name_alias.".self::role_name." as $role_name_alias");
		$this->db->from(self::domain_table.' as '.$domain_name_alias.','.self::roles_table.' as '.$role_name_alias);
		$this->db->where($domain_name_alias.'.'.self::domain_id,$domainID);
		$this->db->join(self::roles_table, $domain_name_alias.'.'.self::domain_id.' = '.$role_name_alias.'.'.self::role_domain_ref);

		$query = $this->db->get();
		
		print_r($this->extract_results($query));
		
		return $this->extract_results($query);
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
		//column aliases
		$domain_alias		= 'domain';
		$role_alias			= 'role';
		$privilege_alias	= 'privilege';
		
		//crafting the query

		
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
	