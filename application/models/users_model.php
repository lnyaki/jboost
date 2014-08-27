<?php
class Users_model extends CI_Model{
	
	public function add_user($data){
		if(!isset($data['username']) && !isset($data['email']) && !isset($data['password'])){
			return false;
		}
		
		$this->load->database('default');
		
		$sql = "insert into users";
		
		return $this->db->query($this->db->insert_string('users',$data));
	}
}