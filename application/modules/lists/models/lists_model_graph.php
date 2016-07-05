<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Lists_model_graph extends TNK_Model{
	
	public function get_all_list_names(){}
	
	public function get_list_content($listname){}
	
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