<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class TNK_Model extends CI_Model{
	const ARRAY_RESULT	= 'array';
	const OBJECT_RESULT	= 'object';
	
	public function model_test(){
		return 'test Model : OK';
	}
	
	public function extract_results($results,$type = self::OBJECT_RESULT){
		$extracted = array();
		
		if($type === self::OBJECT_RESULT){
			foreach($results->result() as $row){
				array_push($extracted,$row);
			}	
		}
		else if($type === self::ARRAY_RESULT){
			foreach($results->result_array() as $row){
				array_push($extracted,$row);
			}
		}
		
		
		return $extracted;
	}
	
	public function extract_results_g($results){
		$extracted = array();
		
		foreach($results->records() as $record){
			//row array
			$row = array();
			//get keys
			$keys = $record->keys();
			
			//for each key, get the value, and add it to a 'row' array
			foreach($keys as $key){
				$row[$key] = $record->value($key);
			}
			
			//add the 'row' array to $extracted
			array_push($extracted,$row);
		}
		
		return $extracted;
	}
}

