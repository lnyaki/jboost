<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class TNK_Model extends CI_Model{
	
	public function model_test(){
		return 'test Model : OK';
	}
	
	public function extract_results($results){
		$extracted = array();
		
		foreach($results->result() as $row){
			array_push($extracted,$row);
		}
		
		return $extracted;
	}
	
	
	public function generate_select(){
		
	}

	public function generate_update($table){
		
	}

	public function generate_insert($table,$fields){
		echo '[TNK_Model.generate_insert]ERR : No fields passed as parameters, or null table name.';
		return $this->db->insert($table,$fields);
	}

	public function generate_delete($table){
		
	}
	
}

