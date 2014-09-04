<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Email_list_model extends CI_Model{
	const table 	= 'emails01';
	//call modes
	public static $cm_01	= array('*');

	public function add_email($data){
		if(!isset($data['email']) || !isset($data['list_ref'])){
			return false;
		}
		
		return $this->db->query($this->db->insert_string(self::table,$data));
	}
	
	public function exists($email,$list_ref){
		$sql = 'select 1 from '.self::table.' where email= ? and list_ref = ?';
		return $this->db->simple_query($sql,array($email,$list_ref));
	}
}