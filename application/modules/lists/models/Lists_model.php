<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Lists_model extends CI_Model{
	const LIST_TABLE 	= 'list';
	
	//call modes
	public static $cm_01	= array('*');
	public static $cm_02	= array('kana','pronounciation','type');
	
	//return the set of all the different lists
	public function get_lists(){
		
		$sql 	= 'SELECT'.$cm_01;
		$sql	.= ' FROM '.self::LIST_TABLE;
	}
	
	//return the set of all the official lists (approved by us)
	public function get_official_lists(){
		
	}
	
	//return the content of the list specified in param
	public function get_list_content($list){
		
	}
	
	//create a list named $list_name, and linked items
	public function create_list($list_name, $items){
		$this->db->trans_start();
		//We need to create an entry in the list table, as well as add the items in list details
			$this->db->insert(self::LIST_ITEMS,$items);
			
			$this->db->insert(self::LIST_TABLE,$items);
		
		$this->db->trans_complete();
		
		return $this->db->query($sql, array($list_name));
	}
	
	//This function takes an array of items and formats them so that they can be inserted in tables
	private function form_data_to_list_item($items){
		$formatted = array();
		
		foreach($items as $key => $value){
			$fieldName 	= $value['key'];
			$fieldValue	= $value['value'];
			
			$formatted[] = array($fieldName => $fieldValue);
		}
		
		return $formatted;
	}
	
	public function add_items($items){
		return $this->db->insert_batch(self::LIST_TABLE,$items);
	}
	
	//Add a single item to the list $list_id
	public function add_item($item){
		//TODO : get the technical segment here.
		return $this->add_items(array('name' => $item));
	}
}