<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lists extends TNK_Controller {

	public function index(){
		$this->load->model('kana/Kana_model','model');

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
			
			$this->add_block($view,self::CENTER_BLOCK);
			$this->add_block($button,self::CENTER_BLOCK);
		}
		else{
		//output warning or something
		}
		$this->generate_page();
	}


	public function display_list2($list_name){
		$this->load->model('kana/Kana_model','model');
		$kana_list	= $this->model->get_kana_list($list_name);
		
		//initialize the left and right side
			$data2['_left_aside']	= '';
			$data2['_right_aside']	= '';
			
			//load the list view to put in the content view
			$data2['_content'] 		 = $this->load->view('lists/character_list_view',array('_list_name' => $list_name, '_list' => $kana_list),TRUE);
			$data2['_content']		.= $this->load->view('lists/update_list_view',null,TRUE);
			
			$data['content']		= $this->load->view('templates/content.php',$data2,true);
			
			$this->create_page($data);
	}
	
	public function display_list($list_name){
	//load js files
		$this->add_js('assets/js/lodash.compat.js');
		$this->add_js('assets/js/module_manager.js');
		$this->add_js('assets/js/module.js');
		$this->add_js('assets/js/test-page.js');
		$this->add_js('assets/js/html_lists.js',true);
		
	//load the views
		$character_list_view	= $this->display_list_widget($list_name);
		$update_view			= $this->update_list_widget();
		$update_view2			= $this->update_list_widget2();
		
	//add the content of the views to the page
		$this->add_block($character_list_view	,self::CENTER_BLOCK);
		$this->add_block($update_view			,self::CENTER_BLOCK);
		$this->add_block($update_view2			,self::CENTER_BLOCK);
	
	//Generate the html page
		$this->generate_page();
	}
	
	
/****************************************************************************
 * 						Widgets
 * 
 ****************************************************************************/

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
		return $this->view('lists/update_list_view',null);
	}
	
	//get the update-list widget
	public function update_list_widget2(){
		return $this->view('lists/update_list_view2',null);
	}

	public function display_list_widget($list_name){
	//load the kana_model so that we can get kana data
		$this->load->model('kana/Kana_model','model');	
	//load a kana list from database
		$kana_list				= $this->model->get_kana_list($list_name);
		
		return $this->view('lists/character_list_view',array('_list_name' => $list_name, '_list' => $kana_list));
	}


	public function create_list_widget(){
		$this->add_script2('Lists','add_element_click_function.php');
		return $this->load->view('lists/create_list_view',array(),TRUE);
	}
	
	public function new_list_widget(){
		$this->load->library('View_generator');
		
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
		$this->view_generator->add_form_element_to_row($row2_config,$textarea,4);
		$this->view_generator->add_form_element_to_row($row2_config,$button1,4);
		$this->view_generator->add_form_element_to_row($row2_config,$multilist,4);

		$row2 	= $this->view_generator->bootstrap_form_row($row2_config);
		//Row 3
		$row3 	= $this->view_generator->bootstrap_form_row(array($button2));
		
		$formInit = array($row1,$row2,$row3);

		return $this->view_generator->generate_form($formInit);
	
	}
	
	//create a new list of characters (kana, kanji)
	public function create_list(){
	//load js files
		$this->add_js('assets/js/lodash.compat.js');
		$this->add_js('assets/js/module_manager.js');
		$this->add_js('assets/js/module.js');
		$this->add_js('assets/js/html_lists.js',true);
	//load the views
		$create_list_view	= $this->create_list_widget();
		$new_list			= $this->new_list_widget();
	//add the content of the views to the page
		$this->add_block($create_list_view	, self::CENTER_BLOCK);
		$this->add_block($new_list,self::CENTER_BLOCK);
		

	//Generate the html page
		$this->generate_page();
	}
	
	//update the content of a list (add or remove characters)
	public function update_list($list){
		
	}
	
	//add items to a list
	public function add_items($list,$items){
		
	}
	
	//logical deletion of an item
	public function remove_items($list,$items){
		
	}
	
	
	//action to take when receiving data from the creation form
	public function creation_form(){
		$this->load->model('lists/Lists_model','model');
		$items = $this->input->post('list');
		
		//temp code
		echo $items."<br/>";
		var_dump($_POST);
	
		//create the list
		$list	= $this->input->post('list');
		//$this->model->create_list($list,$data);
		
		//add the elements (from the "items" object)
		//$this->model->add_item($items);
	}
	
}
	