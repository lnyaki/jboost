<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//class Roles_model extends CI_Model{
	class Roles_model extends TNK_Model{
	//Table names
	const role_table			= 'security_role';
	const domain_table			= 'security_domain';
	const privilege_table		= 'security_privilege';
	const user_privilege_table	= 'security_user_privileges';
	const user_roles_table		= 'security_user_roles';
	
	//Domain Fields
	const domain_id				= 'id';
	const domain_name 			= 'name';
	const domain_description	= 'description';
	const domain_deleted		= 'deleted';
	
	//Role Fields
	const role_id				= 'id';
	const role_name				= 'name';
	const role_domain_ref		= 'domain_ref';
	const role_deleted			= 'deleted';
	
	//User privilege fields
	const user_privilege_id				= 'id';
	const user_privilege_user_ref		= 'user_ref';
	const user_privilege_domain_ref		= 'domain_ref';
	const user_privilege_privilege_ref	= 'privilege_ref';
	
	//Privilege Fields
	const privilege_name		= 'name';
	const privilege_deleted		= 'deleted';
	
	//delete lines below, when sure that it has no impact.
	const main_table 		= 'roles01';
	//const privileges_table	= 'roles01';
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
	public function create_role($data){ 
		return $this->db->insert(self::role_table,$data);
	}
	
	//update a role (modify name, linked privileges, etc)
	public function update_role($roleID, $data){
		$this->db->where(self::role_id,$roleID);
		return $this->db->update(self::role_table,$data);
	}
	
	//logicial deletion of a role
	public function delete_role($roleID){
		$this->update_role($roleID,array(self::role_deleted =>'Y'));	
	}
	
	//TODO : Before implementing this one, we implement the privileges
	//Add a new role to a user
	public function add_role_to_user($roleID,$userID){
		//1. Get the privileges for this role
		
		//2. Add the privileges to the user
	
		//3. Add the role to the user
	}
	
	
	//Remove a role from a user
	public function remove_role_from_user($roleID,$userID){
		
	}
	
	//return the roles/privileges of a user.
	public function get_user_roles($userID){

	}

	//return the list of roles
	public function list_roles(){
		
	}
	
	//list the roles for a domain
	public function list_roles_for_domain($domainID){
		
	}
	
	/******************************************************************************
	 *                       Privilege functions
	 * ****************************************************************************/
	 //Add a single privilege to a user. $privilegeData also contains the ID of the user.
	 public function add_privilege_to_user($privilegeID,$domainID,$userID){
	 	return $this->db->insert(self::user_privilege_table,
	 							  array(self::user_privilege_id				=> $userID,
	 									self::user_privilege_domain_ref 	=> $domainID,
	 									self::user_privilege_privilege_ref 	=> $privilegeID)
								);
	 }
	 
	 //Remove a single privilege from a user
	 public function remove_privilege_from_user($privilegeID,$userID){
	 	$this->db->delete(self::user_privilege_table,
	 							array(self::user_privilege_privilege_ref 	=> $privilegeID,
										self::user_privilege_user_ref		=> $userID));
		echo $this->db->last_query();
	 }
	 
	 //TODO : test
	 //Logical deletion of a privilege (the roles must be corrected too)
	 public function delete_privilege($privilegeID){
	 	$this->update_privilege($privilegeID, array(self::domain_deleted => 'Y'));
	 }
	 
	 //Update a privilege
	 public function update_privilege($privilegeID,$data){
		$this->db->where(self::privilege_name,$privilegeID);
		return $this->db->update(self::privilege_table,$data);
	 }
	 
	//return the list of types of privilege (creation, validation, etc)
	public function get_privileges_list(){
		//crafting the query		
		$this->db->select('*');
		$this->db->from(self::privilege_table);		
		
		$query = $this->db->get();
		print_r($this->extract_results($query));
		
		return $this->extract_results($query);
	}
	
	//return the privileges linked to a role.
	public function get_privileges($role){
		//crafting the query

		
	}
	
	//create a new privilege in security_privilege
	public function create_privilege($privilege){
		return $this->db->insert(self::privilege_table,array(self::privilege_name => $privilege));
	}
}
	