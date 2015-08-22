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
	const LIST_ITEMS_ID					= 'id';
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
		
		$sql 	= 'SELECT *';
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
	public function get_list_items($listname){
		$this->db->select('pi.question, ia.answer');
		$this->db->from('list_items as pi, list_items_answers as ia,list_full_items as fi, list_link_items as link, list');
		$this->db->where('pi.id','fi.item_ref',false);
		$this->db->where('fi.id','ia.full_item_ref',false);
		$this->db->where('link.item_ref','fi.id',false);
		$this->db->where('list.id','link.list_ref',false);
		$this->db->where('list.name',$listname);
		
		$res	= $this->db->get();
		
		return $this->extract_results($res);
	}
	
	//create a list named $list_name, and linked items
	public function create_list2($list_name, $items,$answers){
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
			//Second, we create the actual plain item
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
	
	
	//Create a list. Each item to add has an array of answers
	public function create_list($listname,$items){
		$this->db->trans_start();
		//First, we create the new list, and get its id back
		$this->db->insert(self::LIST_TABLE,array(self::LIST_NAME => $listname));
		$list_id = $this->db->insert_id();
		//echo "**************** Create_list ************** <br/>";
		//echo "*** List Created : ID $list_id <br/>";
	
		//Each item is an array with the item, and an array of its answers
		foreach($items as $item => $answers){
			$this->add_single_item($item,$answers,$list_id);
		}
		
		return $this->db->trans_complete();
	}
	
	public function add_single_item($item,$answers,$list_id){
		//echo "******** Add single item ********<br/>";
		$this->db->trans_start();
		//1. Add the plain item
		$itemID = $this->smart_add_plain_item($item);
		//echo "*** ITEM : $item<br/>";
		//echo "*** PLAIN ITEM ID : $itemID <br/>";
		//2. Add the full item (TODO:FOR NOW, WE DUPLICATE. WE MAY CHANGE THAT LATER).
		$fullItemID	= $this->add_full_item($itemID);
		//echo "*** FULL ITEM ID : $fullItemID <br/>";
		//3. We add the answers
		$this->add_item_answers($fullItemID, $answers);
		//4. Link the item to the list
		$this->db->insert(self::LIST_LINK_ITEMS_TABLE,array(self::LIST_LINK_ITEMS2_REF => $fullItemID,
															self::LIST_LINK_ITEMS_LIST_REF => $list_id));
		$this->db->trans_complete();
		//echo "******** END add single item ********<br/><br/>";
	}
	
	public function add_full_item($plainItemID){
		$this->db->insert(self::LIST_FULL_ITEMS_TABLE,array(self::LIST_FULL_ITEM2_REF => $plainItemID));
		return $this->db->insert_id();
	}
	
	private function add_item_answers($fullItemID,$answers){
		//Add the full item id to the $answers array
		$this->add_row_to_array(self::LIST_ITEMS_ANSWERS_FULLITEM_REF,$fullItemID,$answers);
		//Perform the insert
		return $this->db->insert_batch(self::LIST_ITEMS_ANSWERS_TABLE,$answers);
	}
	
	public function add_row_to_array($rowname,$staticValue,&$array){
		foreach($array as &$row){
			$row[$rowname]	= $staticValue;
		}		
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
	
	//Checks if a plain item exists. If yes, it returns its id. If no, the item is added, and
	//its id is retrieved.
	public function smart_add_plain_item($item){
		$this->db->select(self::LIST_ITEMS_ID);
		$this->db->from(self::LIST_ITEMS_TABLE);
		$this->db->where(self::LIST_ITEMS_QUESTION,$item);
		
		$res = $this->db->get();
		$res = $res->result();
		print_r($res);
		$itemID = 0;
		
		//If the item doesn't already exist
		if(count($res)===0){
			$this->db->insert(self::LIST_ITEMS_TABLE,array(self::LIST_ITEMS_QUESTION => $item));
			
			$itemID = $this->db->insert_id();
		}
		//if item already exists, extract the id
		else{
			$itemID = $res[0]->id;
		}	
		
		return $itemID;
	}
	
	public function smart_add_full_item($itemID){
		$this->db->select(self::LIST_FULL_ITEMS_ID);
		$this->db->from(self::LIST_FULL_ITEMS_TABLE);
		$this->db->where(self::LIST_FULL_ITEM2_REF,$itemID);
		
		$res = $this->db->get();
		$res = $res->result();
		print_r($res);
		$fullItemID = 0;
		
		//If there is no full item for this item
		if(count($res) === 0){
			$this->db->insert(self::LIST_FULL_ITEMS_TABLE,array(self::LIST_FULL_ITEM2_REF => $itemID));
			
			$fullItemID = $this->db->insert_id();
		}
		//If there is one or more existing full items
		else{
			$fullItemID = $res;
		}
		
		return $fullItemID;
	}
	
	//This function adds a plain item in table list_items. A plain item is the "key" part
	//of a key/value pair. This allows one key to have several possible value sets.
	public function add_plain_item($item){}
}