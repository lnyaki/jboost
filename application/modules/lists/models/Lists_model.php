<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Lists_model extends CI_Model{
	const main_table 	= 'kana01';
	
	//call modes
	public static $cm_01	= array('*');
	public static $cm_02	= array('kana','pronounciation','type');
	
	//return the set of all the different lists
	public function get_lists(){
		
		$sql 	= 'SELECT'.$cm_01;
		$sql	.= ' FROM '.self::main_table;
	}
	
	//return the set of all the official lists (approved by us)
	public function get_official_lists(){
		
	}
	
	//return the content of the list specified in param
	public function get_list_content($list){
		
	}
	
	//create a list named $list_name
	public function create_list($list_name){
		
	}
}