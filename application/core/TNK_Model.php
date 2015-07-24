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
}

