<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//class Roles_model extends CI_Model{
	class Roles_model extends TNK_Model{
	//Table names
	const role_table				= 'security_role';
	const domain_table				= 'security_domain';
	const privilege_table			= 'security_privilege';
	const role_privilege_table		= 'security_role_privilege';
	const user_privilege_table		= 'security_user_privileges';
	const user_roles_table			= 'security_user_roles';
	const domain_privilege_table	= 'security_domain_privilege';
	const role_view					= 'security_roles_v';
	
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
	
	//Role view fields
	const role_view_role		= 'role';
	const role_view_privilege	= 'privilege';
	const role_view_domain		= 'domain';

	//Role privilege
	const role_privilege_role_ref		= 'role_ref';
	const role_privilege_privilege_ref	= 'privilege_ref';
	
	//User Role
	const user_role_user_ref	= 'user_ref';
	const user_role_role_ref	= 'role_ref';
	
	//Domain privilage
	const domain_privilege_domain_ref		= 'domain_ref';
	const domain_privilege_privilege_ref	= 'privilege_ref';
	
	//User privilege fields
	const user_privilege_id				= 'id';
	const user_privilege_user_ref		= 'user_ref';
	const user_privilege_domain_ref		= 'domain_ref';
	const user_privilege_privilege_ref	= 'privilege_ref';
	
	//Privilege Fields
	const privilege_name		= 'name';
	const privilege_deleted		= 'deleted';
	
	//Reference to some words
	const privilege				= 'privilege';
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
	public function list_domain_roles($domainID,$listByID = 'true'){
		//column aliases
		$domain_name_alias	= 'domain';
		$role_name_alias	= 'role';
		
		//crafting the query
		$this->db->select($role_name_alias.'.'.self::role_domain_ref.",$domain_name_alias.".self::domain_name." as $domain_name_alias,$role_name_alias.".self::role_name." as $role_name_alias");
		$this->db->from(self::domain_table.' as '.$domain_name_alias);
		
		if($listByID){
			$this->db->where($domain_name_alias.'.'.self::domain_id,$domainID);
		}
		else{
			$this->db->where($domain_name_alias.'.'.self::domain_name,$domainID);
		}
		
		$this->db->join(self::role_table.' as '.$role_name_alias, $domain_name_alias.'.'.self::domain_id.' = '.$role_name_alias.'.'.self::role_domain_ref);

		$query = $this->db->get();

		return $this->extract_results($query);
	}
	
	public function list_domains(){
		$this->db->select(self::domain_id.','.self::domain_name.','.self::domain_description);
		$this->db->from(self::domain_table);
		
		$query = $this->db->get();
		
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
		//we use a transaction to make sure that everything stays consistent
		$this->db->trans_start();
		//1. Get the privileges for this role
		$RolePrivileges = $this->get_role_privileges($roleID);
		
		//1.1 Format the result so that it can be used to add privileges to a user.
		$RolePrivileges = $this->format_privilege_sql_response($RolePrivileges,$userID);
		
		//2. Add the privileges to the user
		$this->add_multiple_privileges_to_user($RolePrivileges,$userID);
		
		//3. Add the role to the user, in the user_role table
		$this->add_entry_in_user_role_table($userID,$roleID);
	
		$this->db->trans_complete();
	}
	
	//Add a role to the user. This is non functional (for documentation purpose).
	public function add_entry_in_user_role_table($userID,$roleID){
		if(!$this->already_has_role($userID,$roleID)){
			$this->db->insert(self::user_roles_table,array(self::user_role_user_ref => $userID, self::user_role_role_ref => $roleID));
		}
		else{
			echo "<br/>ROLE DEJA PRESENT<br/>";
		}
	}
	
	//Add a privilege to a certain role
	public function add_privilege_to_role($privilegeID){
		
	}
	
	//Remove a privilege from a role.
	public function remove_privilege_from_role($privilegeID){
		
	}
	
	//Remove a role from a user
	public function remove_role_from_user($roleID,$userID){
		//1. Get the privileges for each role of the user
		
		//2. Get the privileges of the role to remove
		
		//3. For each privilege of the role to remove, we check if the privilege
		//   is present in more than one role. If yes, this privilege should not
		//   be removed. If it is only present in this role, it should be removed.
		
	}
	
	//return the roles/privileges of a user.
	public function get_user_roles($userID){

	}

	//return the list of roles
	public function list_roles(){
		//crafting the query
		$this->db->select(self::role_view_domain.','.self::role_view_role.','.self::role_view_privilege);
		$this->db->from(self::role_view);
		
		$query = $this->db->get();
		
		return $this->extract_results($query);
	}
	
	//list the roles for a domain
	public function list_roles_for_domain($domainID){
		
	}
	
	public function list_privileges_of_role($roleID){
		$privilege = 'p';
		$role = 'r';
		//crafting the query
		$this->db->select("$role.".self::role_privilege_role_ref.", $role.".self::role_privilege_privilege_ref);
		$this->db->from(self::role_privilege_table." as $role");
		$this->db->where($role.'.'.self::role_privilege_role_ref, $roleID);
		$this->db->join(self::privilege_table.' as p', $role.'.'.self::role_privilege_privilege_ref.'='.$privilege.'.'.self::privilege_name);
		
	
		$query = $this->db->get();
		echo $this->db->last_query().'<br/>';
		return $this->extract_results($query);
	}
	
	public function list_privileges_of_role_by_name($roleName){
		$privilege = 'p';
		$role = 'r';
		//crafting the query
		$this->db->select(self::role_table.'.'.self::role_name." as role_name,$role.".self::role_privilege_role_ref.", $role.".self::role_privilege_privilege_ref);
		$this->db->from(self::role_privilege_table." as $role");
		//$this->db->where($role.'.'.self::role_privilege_role_, $roleName);
		$this->db->where(self::role_table.'.'.self::role_name,$roleName);
		$this->db->join(self::privilege_table.' as p', $role.'.'.self::role_privilege_privilege_ref.'='.$privilege.'.'.self::privilege_name);
		$this->db->join(self::role_table,self::role_table.'.'.self::role_id.'='.$role.'.'.self::role_privilege_role_ref);
		
		$query = $this->db->get();
		
		return $this->extract_results($query);
	}
	
	//Receive an array of privileges comming from get_role_privileges, and format it to
	//be used in function add_multiple_privileges_to_user
	public function format_privilege_sql_response($privilegeArray,$userID){
		$result = array();
		
		foreach($privilegeArray as $row){
			$elt = array();
			
			$row = (array) $row;
			
			$elt[self::user_privilege_user_ref]			= $userID;
			$elt[self::user_privilege_domain_ref]		= $row[self::role_domain_ref];
			$elt[self::user_privilege_privilege_ref]	= $row[self::privilege_name];
			
			array_push($result,$elt);
		}
		
		return $result;
	}
	
	/******************************************************************************
	 *                       Privilege functions
	 * ****************************************************************************/	 
	//create a new privilege in security_privilege
	public function create_privilege($privilege){
		return $this->db->insert(self::privilege_table,array(self::privilege_name => $privilege));
	}

	 //Add a single privilege to a user.
	 public function add_privilege_to_user($privilegeID,$domainID,$userID){
	 	$res = true;
	 	//1. Verify if the current privilege exists. If yes, we do nothing. If not, we add it.
	 	if(!$this->user_privilege_exists($privilegeID,$domainID,$userID)){
	 		$res = $this->db->insert(self::user_privilege_table,
	 							  array(self::user_privilege_user_ref		=> $userID,
	 									self::user_privilege_domain_ref 	=> $domainID,
	 									self::user_privilege_privilege_ref 	=> $privilegeID)
								);
	 	}
	 	return $res;
	 }
	 
	 public function add_multiple_privileges_to_user2($privileges){
	 	return $this->db->insert_batch(self::user_privilege_table,$privileges);
	 }
	 
	 //TODO : change. This below is really ADD a ROLE, not ADD multiple privileges
	 //Add multiple privileges to a user
	 public function add_multiple_privileges_to_user($newPrivileges,$userID){
	 	//We need to get the privilege which don't already exist for this user.
	 	$privileges_to_add = $this->get_privileges_to_add($newPrivileges,$userID);
		
		echo "<br/>Role privileges <br/>";
		print_r($newPrivileges);
		echo "<br/>PRIVILEGES TO ADD<br/>";
		print_r($privileges_to_add);
		
		if(count($privileges_to_add) == 0){
			return true;
		}
		else{
			return $this->db->insert_batch(self::user_privilege_table,$privileges_to_add);
			
		}
	 }
	 
	 //Remove a single privilege from a user
	 public function remove_privilege_from_user($privilegeID,$userID){
	 	$this->db->delete(self::user_privilege_table,
	 							array(self::user_privilege_privilege_ref 	=> $privilegeID,
										self::user_privilege_user_ref		=> $userID));
		echo $this->db->last_query();
	 }

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
	public function get_role_privileges($roleID){
		$role_alias			= 'rp';
		$privilege_alias	='p';
		//crafting the query
		$this->db->select(self::role_table.'.'.self::role_domain_ref.",$role_alias.".self::role_privilege_role_ref.", $privilege_alias.".self::privilege_name);
		$this->db->from(self::role_privilege_table." as $role_alias,".self::privilege_table." as $privilege_alias");
		$this->db->where("$role_alias.".self::role_privilege_role_ref,$roleID);
		$this->db->where($role_alias.'.'.self::role_privilege_role_ref.' = '.self::role_table.'.'.self::role_id);
		$this->db->join(self::role_table, $role_alias.'.'.self::role_privilege_privilege_ref.'='.$privilege_alias.'.'.self::privilege_name);
		
		$query	= $this->db->get();
		
		print_r($this->extract_results($query));
		echo $this->db->last_query();
		
		return $this->extract_results($query);
	}
	
	//return the privilege from the user.
	public function get_user_privileges($userID){
		//crafting the query
		$this->db->select('d.'.self::domain_name.' as domain,'.self::user_privilege_domain_ref.' as domainID,'.self::user_privilege_privilege_ref.' as '.self::privilege);
		$this->db->from(self::user_privilege_table);
		$this->db->where(self::user_privilege_user_ref,$userID);
		$this->db->join(self::domain_table.' d', 'd.'.self::domain_id.'='.self::user_privilege_domain_ref);
		$query = $this->db->get();
		
		return $this->extract_results($query);
	}
	
	//return the privileges for a domain
	public function get_domain_privileges($domainID){
		//crafting the query
		$this->db->select('d.'.self::domain_name.',p.'.self::privilege_name);
		$this->db->from(self::domain_table.' as d,'.self::domain_privilege_table.' as dp,'.self::privilege_table.' as p');
		$this->db->where($domainID,self::domain_id);
		$this->db->where('d.'.self::domain_id,'dp.'.self::domain_privilege_privilege_ref);
		$this->db->where('dp.'.self::domain_privilege_privilege_ref,'p.'.self::privilege_name);
		
		$query = $this->db->get();
		
		return $this->extract_results($query);	
	}
	
	//Return all the privileges, with their domain
	public function get_all_domain_privileges(){$champ = 'dp.'.self::domain_privilege_domain_ref.'='.'d.'.self::domain_id;
		//crafting the query
		/* FOR some reason, this query doesn't work. I ended up using a join, but it doesn't work
		 * either. This issue seems to lie with the backticks used by codeigniter. The resulting query is :
		 * SELECT `d`.`name`, `p`.`name` 
FROM (`security_domain_privilege` as dp) 
JOIN `security_privilege` as p ON `dp`.`privilege_ref`=`p`.`name` 
JOIN `security_domain` as d ON `dp`.`domain_ref`=`d`.`id` WHERE `d`.`id` = 'dp.domain_ref' AND `dp`.`privilege_ref` = 'p.name' 
		 * 
		$this->db->select('d.'.self::domain_name.',p.'.self::privilege_name);
		$this->db->from(self::domain_privilege_table.' as dp');
		$this->db->where('d.'.self::domain_id,'dp.'.self::domain_privilege_domain_ref);
		$this->db->where('dp.'.self::domain_privilege_privilege_ref,'p.'.self::privilege_name);
		$this->db->join(self::privilege_table.' as p', 'dp.'.self::domain_privilege_privilege_ref.'='.'p.'.self::privilege_name);
		$this->db->join(self::domain_table.' as d', $champ);		
		
		
		$this->db->order_by('d.'.self::domain_name,'desc');
		$query = $this->db->get();
		*/
		$sql = "SELECT  `d`.`name` as Domain,  `p`.`name` as Privilege, `d`.`id` as domainID FROM (`security_domain` AS d,  `security_domain_privilege` AS dp,  `security_privilege` AS p) WHERE d.id = dp.domain_ref AND dp.privilege_ref = p.name";
		$query = $this->db->query($sql);
	
		return $this->extract_results($query);	
	}
	
	//Return true if a privilege corresponding to the parameters already exists in security_user_privileges
	private function user_privilege_exists($privilegeID,$domainID,$userID){
		$this->db->select(self::user_privilege_privilege_ref);
		$this->db->from(self::user_privilege_table);
		$this->db->where(self::user_privilege_user_ref,$userID);
		$this->db->where(self::user_privilege_domain_ref,$domainID);
		$this->db->where(self::user_privilege_privilege_ref,$privilegeID);
		
		$query = $this->db->get();
		
		//If the number of rows is superior to 0, this privilege already exists
		if ($query->num_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}
	
	private function already_has_role($userID,$roleID){
		$this->db->select(self::user_role_user_ref);
		$this->db->from(self::user_roles_table);
		$this->db->where(self::user_role_user_ref,$userID);
		$this->db->where(self::user_role_role_ref,$roleID);
		
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			return true;
		}
		else{
			return false;
		}
	}
	
	//Take the privilege that will be added to the user, and only send back those
	//that the user doesn't already have.
	private function get_privileges_to_add($privilegesToAdd,$userID){		

		if(count($privilegesToAdd)>0){
			//get the privilege of the user
			$userPrivileges	= $this->get_user_privileges($userID);
			
			return $this->get_new_user_privileges($userPrivileges,$privilegesToAdd);
		}
		else{
			return array();
		}
	}
	
	//Take the current user privileges, the privileges that we want to add, and return the privileges that
	//we want to add, and which are not already in the current user privileges.
	private function get_new_user_privileges($userPrivileges,$privilegesToAdd){
		$newPrivileges = array();
		
		//if the user doesn't have privileges already, we can directly add whatever we want.
		//If the $privileges to add are empty, we return this empty array too.
		if(count($userPrivileges) == 0 or count($privilegesToAdd) == 0){
			return $privilegesToAdd;
		}
		else{
			//we loop on the privileges to add and check if they are already in the user privileges list
			foreach($privilegesToAdd as $row){
				//if the current privilege is not in the user privilege list, we can add it
				//to the $newPrivileges
				if(!$this->is_privilege_in($row,$userPrivileges)){
					array_push($newPrivileges,$row);
				}
				else{
					echo "<br/> Le privilege suivant est déjà présent :<br/>";
					print_r($row);
					echo "<br/>";
				}
			}
		}
		
		return $newPrivileges;
	}
	
	//Return true if $privilege is in the $privilegeList. Returns false otherwise.
	private function is_privilege_in($privilege,$privilegeList){
		$exit 	= false;
		$i		= 0;
		
		$length = count($privilegeList);
		//If the privlege list is empty, then the privilege is not in the list(we return false)
		if($length == 0){
			return false;
		}
		
		while(! $exit and $i < $length){
			$row = (array)$privilegeList[$i];
			
			//if the $privilege can be found in $privilegeList, we return 'true';
			if(	$row[self::role_domain_ref] 				== $privilege[self::user_privilege_domain_ref] and
				$row[self::role_privilege_privilege_ref] 	== $privilege[self::user_privilege_privilege_ref]
			){
				$exit = true;
			}
			
			$i++;
		}
		
		return $exit;
	}
	
}
	