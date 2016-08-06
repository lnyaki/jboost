<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Lists_model_graph extends TNK_Model{
	//These constants define the possible types of list elements
	const KANATYPE 	= "kana";
	const KANJITYPE	= "Kanji";
	const DICOTYPE	= "Dictionary";
	const QUIZZTYPE	= "Quizz";
	
	/* The constants below describe the type of list display. We consider 3 values,
	 * corresponding to the level of details returned by each query : light, normal,full.
	*/
	const DETAIL_LIGHT 	= "light";		//The bare minimum information.
	const DETAIL_MEDIUM	= "medium";		//Some pretty complete information
	const DETAIL_FULL	= "full";		//All the relevant information we can find.
	
	
	//Return all sublists of list $list
	public function get_sublists($list){
		$db = $this->neo4j->get_db();
		
		$query = "match (n:item_list{name:'$list'})-[:sublist*]->(sublist:item_list) sublist.name as list";
		$result	= $db->run($query);
		
		return $this->extract_results_g($result);	
	}
	
	public function get_all_list_names(){
		$db 	= $this->neo4j->get_db();
		$query	= "match (n:item_list{name:'Lists'})-[:sub_list*]->(list:item_list{public:true}) return list.name as Name, list.type as Type order by list.name";
		$result	= $db->run($query);
		return $this->extract_results_g($result);
	}
	
	//Return the type of the list (hiragana,katakana,kanji,dico,question/answer)
	public function get_list_type($listname){
		$db		= $this->neo4j->get_db();
		$query	= 'match(n:item_list{name: "'.$listname.'"}) return n.type as type';
		$result	= $db->run($query);
		
		return $this->extract_results_g($result);
	}
	
	//Return all the elements of that list (including elements from sublists)
	public function get_list_content($listname,$type = self::KANJITYPE,$detail = self::DETAIL_MEDIUM){
		$db = $this->neo4j->get_db();
		$query	= '';
		/*
		 * For each type of list, we identify 3 details level, which determine how much data
		 * we should return. Light is just the bare minimum. Medium is some relatively complete information.
		 * Full is all the information that we can possibly return. 
		 */
		switch($type){
			case self::KANATYPE 	:
				if($detail === self::DETAIL_LIGHT){
					$query  = "match(list:item_list)-[:sub_list*0..]->(sublist)-[:list_item]->(character:item)-[:romaji]->(romaji:item) where list.name =~ '(?i)".$listname."'";
					$query .= " return character.value as Kana, romaji.value as Romaji order by character.value";
				}
				//Return hiragana (or katakana)from a list, as well as the corresponding romaji, and corresponding value from katakana (or hiragana)
				else if($detail === self::DETAIL_MEDIUM){
					$query  = "match(list:item_list)-[:sub_list*0..]->(sublist)-[:list_item]->(character:item)-[r:romaji]->(romaji:item) where list.name =~ '(?i)$listname'";
					$query .= " with character,r,romaji optional match (character)-[r]->(romaji)<-[:romaji]-(kana:item)<-[:list_item]-(kanaList:item_list{type : 'kana'})";
					$query .= " return character.value as kana1, romaji.value as romaji, kana.value as kana2 order by character.value";
				}
				else if ($detail === self::DETAIL_FULL){
					
				}
				break;
			
			//Return the kanji with its onyomi and kunyomi
			case self::KANJITYPE	:				
				if($detail === self::DETAIL_LIGHT){
					
				}
				else if($detail === self::DETAIL_MEDIUM){
					$query  = "match(list:item_list{name:'".$listname."'})-[:list_item]->(kanji:item) with kanji ";
					$query .= "optional match (kanji)-[:reading{type : 'kunyomi'}]->(kunyomi:item)-[:romaji]->(r1:item) with kanji,kunyomi,r1 ";
					$query .= "optional match (kanji)-[:reading{type : 'onyomi'}]->(onyomi:item)-[:romaji]->(r2:item) ";
					$query .= "with kanji.value as kanji, kanji.strokes as strokes, collect(distinct([kunyomi.value,r1.value])) as tmpKunyomi, ";
					$query .= "collect(distinct([onyomi.value,r2.value])) as tmpOnyomi ";
					$query .= "return kanji, strokes,";
					$query .= "case tmpKunyomi when [[null,null]] then null else tmpKunyomi END as kunyomi, ";
					$query .= "case tmpOnyomi when [[null,null]] then null else tmpOnyomi END as onyomi";
				}
				else if ($detail === self::DETAIL_FULL){
					
				}
				break;

			case self::DICOTYPE		:
				if($detail === self::DETAIL_LIGHT){
					
				}
				else if($detail === self::DETAIL_MEDIUM){
					
				}
				else if ($detail === self::DETAIL_FULL){
					
				}
				break;
			
			case self::QUIZZTYPE	:
				if($detail === self::DETAIL_LIGHT){
					
				}
				else if($detail === self::DETAIL_MEDIUM){
					
				}
				else if ($detail === self::DETAIL_FULL){
					
				}
				break;
				
			default : echo "PROBLEM in list type $type";	
		}
		
		
		
		$result = $db->run($query);
		return $this->extract_results_g($result);
	}
	
	//Return all the elements that belong strictly to that list. It doesn't return the elements from sublists.
	public function get_strict_list_content($listname, $type){
		$db = $this->neo4j->get_db();
		
		$query	= '';

		switch($type){
			case self::KANATYPE 	:
				$query  = "match(list:item_list)-[:list_item]->(character:item)-[:romaji]->(romaji:item) ";
				$query .= "where list.name =~ '(?i)".$listname."' and list.type = '".$type."'";
				$query .= " return character.value as Kana, romaji.value as Romaji";
				break;
			
			case self::KANJITYPE	:
				break;
				
			case self::DICOTYPE		:
				break;
			
			case self::QUIZZTYPE	:
				break;
				
			default : ;	
		}
		
		
		$query  = "match(list:item_list)-[:list_item]->(item:item) where list.name =~ '(?i)".$listname."'";
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
		
		$query  = "match(list:item_list)-[:sub_list*0..]->(sublist)-[:list_item]->(character:item)-[:romaji]->(romaji:item) where list.name =~ '(?i)".$listname."'";
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