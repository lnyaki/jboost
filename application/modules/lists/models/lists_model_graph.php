<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Lists_model_graph extends TNK_Model{
	
	//Return all sublists of list $list
	public function get_sublists($list){
		$db = $this->neo4j->get_db();
		
		$query = "match (n:item_list{name:'$list'})-[:sublist*]->(sublist:item_list) sublist.name as list";
		$result	= $db->run($query);
		
		return $this->extract_results_g($result);	
	}
	
	public function get_all_list_names(){
		$db 	= $this->neo4j->get_db();
		$query	= "match (n:item_list{name:'Lists'})-[:sub_list*]->(list:item_list{public:true}) return list.name as Name order by list.name";
		$result	= $db->run($query);
		return $this->extract_results_g($result);
	}
	
	//Return all the elements of that list (including elements from sublists)
	public function get_list_content($listname, $sublist_content = true){
		$db = $this->neo4j->get_db();
		
		$query  = "match(list:item_list)-[:sub_list*0..]->(sublist)-[:list_item]->(item:item) where list.name =~ '(?i)".$listname."'";
		$query .= " return item.value as value";
		
		$result = $db->run($query);
		return $this->extract_results_g($result);
	}
	
	//Returns list of kana elements (kana --> romaji)
	public function get_kana_list_content($listname){
		$db = $this->neo4j->get_db();
		
	//	$query  = "match(list:item_list)-[:sub_list*0..]->(sublist)-[:list_item]->(kana:item)-[:romaji]->(romaji:item) where list.name =~ '(?i)".$listname."'";
		//$query .= " return kana.value, romaji.value  ORDER BY kana asc";
		
		//$query  = "match(list:item_list)-[:sub_list*0..]->(sublist)-[:list_item]->(kana:item)-[:romaji]->(romaji:item) where list.name =~'(?i)Hiragana'";
		//$query .= "return kana.value as kana, romaji.value as answer  ORDER BY kana asc";
		
		$query  = "match(list:item_list)-[:sub_list*0..]->(sublist)-[:list_item]->(character:item)-[:romaji]->(romaji:item) where list.name =~ '(?i)Hiragana'";
		$query .= "return character.value as item, romaji.value as answer";
		
		
		$result = $db->run($query);
		return $this->extract_results_g($result);
	}
	
	//Returns list of kanji elements (kanji --> onyomi,kunyomi,translation)
	public function get_kanji_list(){
		
	}
	
	//Returns list of words (word --> hiragana, definition, category)
	public function get_word_list(){
		
	}
	
	public function get_quizz_list(){
		
	}
	
	public function create_list($listname){}
	
	public function add_list_item($listname,$item){}
	
	public function add_list_items($listname,$items){}
	
	public function add_answer_to_item($item,$answer){}
	
	public function modify_item_answer($item,$newAnswer){}
	
	//******************************************************************************
	//  Trying to get 'out of the box' function, to make use of graph capabilities
	//******************************************************************************
	//Returns a set of all the lists in the same category as $list
	public function get_lists_in_same_category_as($list){}
	
	//Returns a set of all the lists in $category
	public function get_lists_in_category($category){}
	
	//Returns a set of lists whose difficulty is on par with the list in parameter
	public function get_lists_for_similar_levels($list){}
	
	//Return the lists that my friends are working on
	
	//Return the lists that my friends have completed, and that are at my level
	
	//Return the lists that i haven't done that are just above my level
	
	//Return the users who have completed/used this list today
	
	//Return a list of all the people who have added/updated items in this list
}