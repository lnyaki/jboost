<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lists extends TNK_Controller {

	public function index(){
		$this->load->model('Kana/Kana_model','model');
		$lists = $this->model->get_kana_lists();
		
		if($lists){
			//load the library that generates tables from arrays of data
			$this->load->library('View_generator');
			
			$prefix = base_url().'lists';
						
			//set the links for the fields of the array
			$links = array();
			$links = $this->view_generator->create_row_link($links,2,array(2),$prefix);
			$links = $this->view_generator->create_row_link($links,1,array(1),$prefix);

			$view 	= $this->view_generator->generate_array($lists[1],null,$links);
			$button	= $this->new_list_button_widget();
			$listnames	= $this->list_names_widget();
			
			$this->add_block($view,self::CENTER_BLOCK);
			$this->add_block($button,self::CENTER_BLOCK);
			$this->add_block($listnames,self::CENTER_BLOCK);
		}
		else{
		//output warning or something
		}
		$this->generate_page();
	}

	public function display_list($list_name){
	//load js files
		$this->add_js('assets/js/lodash.compat.js');
		$this->add_js('assets/js/module_manager.js');
		$this->add_js('assets/js/module.js');
		$this->add_js('assets/js/test-page.js');
		$this->add_js('assets/js/html_lists.js',true);
	//load the views
		//TODO : displayList_widget is deprecated : to remove
		$character_list_view	= $this->display_list_widget($list_name);
		//remove call to function above
		$list 					= $this->get_list_items_widget($list_name);
		$update_view			= $this->update_list_widget();
		$update_view2			= $this->update_list_widget2();
		
	//add the content of the views to the page
		$this->add_block($character_list_view	,self::CENTER_BLOCK);
		$this->add_block($list					,self::CENTER_BLOCK);
		$this->add_block($update_view			,self::CENTER_BLOCK);
		$this->add_block($update_view2			,self::CENTER_BLOCK);
	
	//Generate the html page
		$this->generate_page();
	}
	
	
/****************************************************************************
 * 						Widgets
 * 
 ****************************************************************************/
	public function get_list_items_widget($listname){
		//Load models and libraries
		$this->load->library('View_generator','generator');
		$this->load->model('lists/lists_model','list');
		$list_items	= $this->list->get_list_items($listname);
		
		$view = $this->view_generator->generate_array($list_items,null);
		
		return $view;	
	}
	
	//This function returns an array of all the lists.
	public function list_names_widget(){
		//Load models and libraries
		$this->load->library('View_generator','generator');
		$this->load->model('lists//lists_model','list');
		//Load list data
		$real_lists = $this->list->get_lists();
		
		//create links
		$prefix = base_url().'lists';
		$links = $this->view_generator->create_row_link(array(),2,array(2),$prefix);
		
		$widget = $this->view_generator->generate_array($real_lists,null,$links);
		
		return $widget;
	}
	public function new_list_button_widget(){
		$this->load->library('View_generator');

		$data = array(
			'content'	=> 'Create new list',
			'id'		=> 'newListButton',
			'class'		=> 'btn btn-success',
		);
		$path 	= base_url().'lists/create';

		return "<a href='$path'>".$this->view_generator->generate_form_element($data,View_generator::BUTTON)."</a>";
	}
	
	//get the update-list widget
	public function update_list_widget(){
		//TODO : add call to a script here, to handle the sending of data (form?)
		$this->load->library('roles/Security');
		$this->security->set_view_restriction('Lists','update_own');
		
		if($this->security->has_access_to_view()){
			return $this->view('lists/update_list_view',null);	
		}
		else{
			return '';
		}
	}
	
	//get the update-list widget
	public function update_list_widget2(){
		return $this->view('lists/update_list_view2',null);
	}

	public function display_list_widget($list_name){
	//TODO : this is legacy. It just offers the list title now. TO remove when i have some time
		return $this->view('lists/character_list_view',array('_list_name' => $list_name, '_list' => array()));
	
	$this->load->model('lists/lists_model','list');
	//1 : load data from the list module (not the kana)
	$data	= $this->list->load_list_items($list_name);
	//2 : generate the html array
	
	//3 : return the html array
	
	}


	public function create_list_widget(){
		$this->add_js('assets/js/html_lists.js',true);
		//$this->add_module_js('Lists','html_lists.js',true);
		$this->add_script2('lists','add_element_click_function.php');
		return $this->load->view('lists/create_list_view',array(),TRUE);
	}
	
	public function new_list_widget(){
		$this->load->library('View_generator');
		//They will need to be added later, but i comment them for now
		//$this->add_js('assets/js/html_lists.js',true);
		//$this->add_script2('Lists','add_element_click_function.php');
		
		//--------------------------------------------
		//			Initialize the option arrays
		//--------------------------------------------
		$config_textfield	= array('name'		=> 'list');
		$config_label		= array('content'	=> 'List Name :',
									'for'		=> 'list');
		$config_textarea	= array('id'		=> 'textArea',
									'name'		=> 'textArea',
									'style'		=> 'width : 100%;');
		$config_button1		= array('name'		=> 'buttonAdd',
									'id'		=> 'btn_add_element',
									'class'		=> 'btn btn-primary',
									'content'	=> 'Add Elements');
		$config_button2		= array('name'		=> 'btn_create_list',
									'id'		=> 'btn_create_list',
									'class'		=> 'btn btn-primary',
									'content'	=> 'Create List');
		$config_multilist	= array('name'		=> 'items[]',
									'id'		=> 'select',
									'style'		=> 'width : 100%;height : 30em;',
									'multiple' 	=> 'multiple');
		
		
		
		//--------------------------------------------
		//			Generate form elements
		//--------------------------------------------
		//generate a text field
		$textfield		= $this->view_generator->generate_form_element($config_textfield,View_generator::TEXTFIELD);	
		//generate a label for this field
		$label			= $this->view_generator->generate_form_element($config_label,View_generator::LABEL);
		//generate a textarea
		$textarea		= $this->view_generator->generate_form_element($config_textarea,View_generator::TEXTAREA);
		//generate the "add elements" button
		$button1		= $this->view_generator->generate_form_element($config_button1,View_generator::BUTTON);
		//generate the list element
		$multilist		= $this->view_generator->generate_form_element($config_multilist,View_generator::MULTILIST);
		//generate the "create list" button
		$button2		= $this->view_generator->generate_form_element($config_button2,View_generator::BUTTON);
	
		//Row 1 : no special width for elements, so we can call the function directly, without initialization
		$row1 = $this->view_generator->bootstrap_form_row(array($label,$textfield));
		//Initialize elements, then generate the row
		$row2_config = array();
		$this->view_generator->add_form_element_to_row($row2_config,$textarea,5);
		$this->view_generator->add_form_element_to_row($row2_config,$button1,2);
		$this->view_generator->add_form_element_to_row($row2_config,$multilist,5);

		$row2 	= $this->view_generator->bootstrap_form_row($row2_config);
		//Row 3
		$row3 	= $this->view_generator->bootstrap_form_row(array($button2));
		
		$formInit = array($row1,$row2,$row3);

		return "<div class='panel'><h3>Php generated</h3>".$this->view_generator->generate_form($formInit)."</div>";
	
	}
	
	//create a new list of characters (kana, kanji)
	public function create_list(){
	//Check privileges
		$this->load->library('roles/Security');
	//Specify the pages restrictions
		$this->security->set_page_restriction('Lists','create');
	if(!$this->security->has_access_to_page()){
		show_404();
	}
	//load js files
		$this->add_js('assets/js/lodash.compat.js');
		$this->add_js('assets/js/module_manager.js');
		$this->add_js('assets/js/module.js');
	//load the views
		$create_list_view	= $this->create_list_widget();
		$new_list			= $this->new_list_widget();
	//add the content of the views to the page
		$this->add_block($create_list_view	, self::CENTER_BLOCK);
		//$this->add_block($new_list,self::CENTER_BLOCK);
		

	//Generate the html page
		$this->generate_page();
	}
	
	//update the content of a list (add or remove characters)
	public function update_list(){
		
	}
	
	//add items to a list
	public function add_items($list,$items){
		
	}
	
	//logical deletion of an item
	public function remove_items($list,$items){
		
	}
	
	
	//action to take when receiving data from the creation form
	public function creation_form(){
		$this->load->model('lists/lists_model','model');
		$listname 	= $this->input->post('list');
		$items 		= $this->input->post('items');
		$list_type	= $this->input->post('type');
		
		//The items are of the form key#value ==> we need to format them into a proper array
		$formatted_items	= $this->format_raw_items($items,$list_type);
		
		//create the list
		$this->model->create_list($listname,$formatted_items);
		redirect(base_url().'lists');
		
	}
	
	//Take an array of items of the form key#value and return a proper array $key => $values
	private function format_raw_items($items,$itemType = ''){
		$listItems	= array();
		if($items == null) return $formatted;
		
		//For each item element received from the html FORM
		foreach ($items as $raw_item) {
			$elt		= array();
			$temp 		= explode('#', $raw_item);
			$key		= $temp[0];
			$value 		= implode('#',array_slice($temp,1));
			$answers 	= array($value);
			
			$answersList = array();		
				foreach($answers as $answer){
					$answersList[]	= array(Lists_model::LIST_ITEMS_TYPE => $itemType
											,Lists_model::LIST_ITEMS_ANSWER => $answer);	
				}
			$listItems[$key]	= $answersList;
		}
		return $listItems;
	}
	
	//Take an array of items of the form key#value and return a proper array $key => $values
	private function format_raw_items2($items,$itemType = ''){
		$listItems	= array();
		$answers	= array();
		if($items == null) return $formatted;
		
		//For each item element received from the html FORM
		foreach ($items as $raw_item) {
			$elt	= array();
			$temp 	= explode('#', $raw_item);
			$key	= $temp[0];
			$value 	= implode('#',array_slice($temp,1));
			
			$elt = array(Lists_model::LIST_ITEMS_QUESTION 	=> $key
						,Lists_model::LIST_ITEMS_TYPE		=> $itemType);
			
			$listItems[]	= $elt;
			$answers[]		= $value;
		}
		return array($listItems,$answers);
	}
	
}
	