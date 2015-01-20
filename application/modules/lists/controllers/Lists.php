<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lists extends TNK_Controller {

	public function index(){
		$this->load->model('kana/Kana_model','model');
		$lists = $this->model->get_kana_lists();
		
		$this->load->helper('my_array');

		
		$data	= array();
		$data2 	= array();
		$table = '';
		
		if($lists){
			//the first element of the index is the list of fields
			$thead = html_table_head($lists[0]);
			
			//the second element is the rows
			$column_index 	= 2;
			$href 			= array(base_url().'lists/',$column_index);
			$tbody	= html_table_body($lists[1],'','',$href);
			
			//set up the class of the table 
			$table_class = 'table condensed';
			
			//initialize the left and right side
			$data2['_left_aside']	= '';
			$data2['_right_aside']	= '';
			//load the list view to put in the content view
			$data2['_content'] 		= $this->load->view('lists/list_table_view',array('_thead' => $thead, '_tbody' => $tbody, '_table_class' => $table_class),TRUE);
			$data2['_content']		.= $this->load->view('lists/create_list_view',null,TRUE);
			$data['content']		= $this->load->view('templates/content.php',$data2,true);
		}
		else{
		//output warning or something
		}
		
		$this->create_page($data);
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
		return $this->load->view('lists/create_list_view',array(),TRUE);
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

		
	//add the content of the views to the page
		$this->add_block($create_list_view	, self::CENTER_BLOCK);
		$this->add_block(''					, self::LEFT_BLOCK);
		$this->add_block(''					, self::RIGHT_BLOCK);

	//Generate the html page
		$this->generate_page();
	}
	
	//update the content of a list (add or remove characters)
	public function update_list($list){
		
	}
	
	public function add_items($list, $items){
		
	}
	
	public function remove_items($list,$items){
		
	}
	
}
	