<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Users_model_g extends TNK_Model{
	
	//return the full list of user
	public function get_users(){
		$db = $this->neo4j->get_db();
		
		$query = 'match (n:user) return n.username as username,n.password as password,n.date_of_birth as birthdate,n.gender as gender';
		$result	= $db->run($query);
		
		return $this->extract_results_g($result);
	}
	
	public function add_user($data){}
	
	public function get_user(){}
	
	public function user_exists(){}
	
	//Returns the number
}