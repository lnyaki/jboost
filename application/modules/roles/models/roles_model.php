<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Roles_model extends CI_Model{
	const main_table 		= 'roles01';
	const roles_table		= 'roles01_param';
	const privileges_table	= 'roles01';
	const user_privileges	= 'roles02';

	//call modes
	public static $cm_01	= array('*');
	
	
	//return the roles/privileges of a user.
	public function get_user_roles($userID){
	/*		$sql = "SELECT * FROM ".self::user_privileges;
			$sql	.= " WHERE user_ref = ?"*/
	}
	
	//return the list of types of privilege (creation, validation, etc)
	public function get_privileges_list(){
		$sql	 = "SELECT * FROM ".self::privileges_table;
		
		$operations	= array();
		
		$result	= $this->db->query($sql);
		
		foreach($result->result() as $res){
			array_push($operations,$res);
		} 
		
		return $operations;
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
		
	//return the privileges linked to a role.
	public function get_privileges($role){
		
	}
	
	public function create_role($role){
		
	}
	
	public function create_privilege($privilege){
		
	}
	
	public function delete_role($role){
		
	}
	
	public function delete_privilege($privilege){
		
	}
}
	