<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Lists_model extends TNK_Model{
	/**********************************************
	 * 			Table constants
	 *********************************************/
	//Tables constants
	const LIST_TABLE 				= 'list';
	const LIST_ITEMS_TABLE			= 'list_items';
	const LIST_DETAILS_TABLE		= 'list_details';
	const LIST_FULL_ITEMS_TABLE		= 'list_full_items';
	const LIST_ITEMS_ANSWERS_TABLE	= 'list_items_answers';
	const LIST_LINK_ITEMS_TABLE		= 'list_link_items';
	
	/**********************************************
	 * 			Field constants
	 *********************************************/
	 //List table
	const LIST_ID						= 'id';
	const LIST_NAME						= 'name';
	//List details
	const LIST_DETAILS_ID				= 'id';
	const LIST_DETAILS_TYPE				= 'type';
	const LIST_DETAILS_LIST_REF			= 'list_ref';
	const LIST_DETAILS_ITEM_REF			= 'item_ref';
	const LIST_DETAILS_SEQUENCE			= 'sequence_number';
	//List_item table
	const LIST_ITEMS_QUESTION			= 'question';
	const LIST_ITEMS_ANSWER				= 'answer';
	const LIST_ITEMS_TYPE				= 'type';
	//List_full_items table
	const LIST_FULL_ITEMS_ID			= 'id';
	const LIST_FULL_ITEM2_REF			= 'item_ref';
	//list_items_answers
	const LIST_ITEMS_ANSWERS_ID			= 'id';
	const LIST_ITEMS_ANSWERS_ANSWER		= 'answer';
	const LIST_ITEMS_ANSWERS_LANG		= 'language';
	const LIST_ITEMS_ANSWERS_TYPE		= 'type';
	const LIST_ITEMS_ANSWERS_SEQUENCE	= 'sequence';
	const LIST_ITEMS_ANSWERS_FULLITEM_REF	= 'full_item_ref';
	//list_link_items
	const LIST_LINK_ITEMS_LIST_REF		= 'list_ref';
	const LIST_LINK_ITEMS2_REF			= 'item_ref';
	
	
	//call modes
	public static $cm_01	= array('*');
	public static $cm_02	= array('kana','pronounciation','type');
	
	//return the set of all the different lists
	public function get_lists(){
		
		$sql 	= 'SELECT'.self::$cm_01;
		$sql	.= ' FROM '.self::LIST_TABLE;
		
		$this->db->select(self::$cm_01);
		$this->db->from(self::LIST_TABLE);
		
		$res = $this->db->get();
		
		return $this->extract_results($res);
	}
	
	//return the set of all the official lists (approved by us)
	public function get_official_lists(){
		
	}
	
	//return the content of the list specified in param
	public function get_list_content($list){
		
	}
	
	//create a list named $list_name, and linked items
	public function create_list($list_name, $items,$answers){
		$this->db->trans_start();
		//First, we create the new list, and get its id back
		$this->db->insert(self::LIST_TABLE,array(self::LIST_NAME => $list_name));
		$list_id = $this->db->insert_id();
		echo "LIST CREATED. ID : ".$list_id; echo "<br/>";

		//Forth, insert the answers	
		$i = 0;
		$length = count($answers);	
		foreach($answers as $row){
			$answer = $answers[$i];
			$item = $items[$i];
			$i++;
			//Second, we create the actual item
			$this->db->insert(self::LIST_ITEMS_TABLE,$item);
			$simpleItemID = $this->db->insert_id();
		
			//Third, we create the full_item record, that will link the item with the answers
			$this->db->insert(self::LIST_FULL_ITEMS_TABLE, array(self::LIST_FULL_ITEM2_REF => $simpleItemID));
			$full_item_id = $this->db->insert_id();
			
			//Forth, we add the answer to the item
			$this->db->insert(self::LIST_ITEMS_ANSWERS_TABLE,array(self::LIST_ITEMS_ANSWERS_FULLITEM_REF => $full_item_id
																,self::LIST_ITEMS_ANSWERS_ANSWER	=>$answer));
		
			//Fifth, we link the list to the full items
			$this->db->insert(self::LIST_LINK_ITEMS_TABLE,array(self::LIST_LINK_ITEMS_LIST_REF 	=> $list_id
															,self::LIST_LINK_ITEMS2_REF 	=> $full_item_id));
		}	
		
		$this->db->trans_complete();
		
		return $list_id;
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
	
	//This function adds a plain item in table list_items. A plain item is the "key" part
	//of a key/value pair. This allows one key to have several possible value sets.
	public function add_plain_item($item){}
}