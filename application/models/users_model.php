<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Users_model extends CI_Model{
	const main_table 	= 'users';
	//call modes
	public static $cm_01	= array('*');
	public static $cm_02	= array('username','email','id');
	
	public function add_user($data){
		if(!isset($data['username']) && !isset($data['email']) && !isset($data['password'])){
			return false;
		}
		
		$this->load->database('default');
		
		$sql = "insert into ".self::main_table;
		
		return $this->db->query($this->db->insert_string(self::main_table,$data));
	}
	
	public function get_user($data,$method){
		$this->load->helper('table');
		$sql	= "select ".call_mode(self::$cm_02);
		$sql	.= " from ".self::main_table;
		$array;
		
		if($method === 'email'){
			$sql	.= " where email = ?";
			$array 	= array($data['email']);
		}
		else if($method === 'id'){
			$sql	.= " where id = ?";
			$array 	= array($data['id']);
		}
		else{
			$sql	.= " where id = ?";
			$array 	= array($data['id']);
		}
		
		$result = $this->db->query($sql,$array);
		if($result->num_rows()>0){
			return $result->row();
		}
		else{
			return null;
		}
	}
}