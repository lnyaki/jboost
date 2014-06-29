<?php

class Tables extends TNK_Controller {

	//displays a list of all tables
	public function list_tables(){
	//loading the model
		$this->load->model('Table','tables');
	//get the table list
		$data['_table_list']	= $this->tables->list_tables();
		
	//preparing for when static text will be loaded from outside
		$title = 'Table list';
	//initializing the data object
		$data['title'] = $title;
	//loading views
		$data['content'] 	= $this->load->view('pages/tables/view_list_table',$data,TRUE);
		
		//css & javascript scripts 
		$this->add_css(base_url().'assets/css/test.css');
		$this->create_page($data);
	}
	
	//display informations on a single table
	public function display_table($tableId, $tablename){
	//loading the model
		$this->load->model('Table','tables');
	//preparing for when static text will be loaded from outside
		$title = 'Table : '.$tablename;
	//initializing the data object
		$this->title($title);
		
		$data['_tableid'] 	= $tableId;
		$data['_tablename']	= $tablename;
	//loading data
		//getting fields groups for this table
		$transaction_data				= $this->tables->transaction_load_table($tableId);
		$transaction_data['_tablename']	= $tablename;
		//setting data for the table generation form
		$gen_data['_physical']	=	false;//will need to be true/false depending on the value of the table type
	//loading views
		//loading table fields
		$data['_table']				= $this->load->view('pages/tables/view_table_html_table',$transaction_data	,TRUE);
		//loading fieldgroups
		$data['_fieldgroups']		= $this->load->view('pages/tables/view_fieldgroups_table',$transaction_data	,TRUE);
		//loading form for generating physical table
		$data['_generation_form']	= $this->load->view('pages/tables/view_table_generation_form',$gen_data, TRUE);
		//javascript scripts
		$data['_scripts']			= $this->load->view('scripts/test_script', null, TRUE);
		//final page
		$data['content'] 			= $this->load->view('pages/tables/view_table',$data,TRUE);
		
		//css & javascript scripts 
		$this->add_css(base_url().'assets/css/test.css');
		$this->add_js(base_url().'assets/js/test.js');
		$this->create_page($data);
	}
	
	//page to create a new format
	public function add_new_format(){
		//loading the model
		$this->load->model('Table','tables');
		
		$data2['_types'] 	= $this->tables->get_data_types();
		$data['title']		= 'Add new format';
		$data['content']	= $this->load->view('pages/tables/view_add_format', $data2, TRUE);
		
		//css & javascript scripts 
		$this->add_css(base_url().'assets/css/test.css');

		$this->create_page($data);
	}
	
	//add the new format in db
	public function add_new_format_db(){
		//loading the model
		$this->load->model('Table','tables');
		$name	= $this->input->post('format');
		$type	= $this->input->post('type');
		$size	= $this->input->post('size');
		$description	= $this->input->post('description');
		$this->tables->create_format($name, $type, $size, $description);
		echo "format added";
	}
	
	public function test(){
		//loading the model
		$this->load->model('Table','tables');	
		
		//$this->tables->join_test();
		$this->tables->join_test2();
	}
	
	public function constraint(){
		//loading the model
		$this->load->model('Table','tables');	
		
		echo "result : ".$this->tables->create_unique_key("baba", array('f1','f2'), 'bigboss', false);
		die();
	}
	
	public function fk(){
		//loading the model
		$this->load->model('Table','tables');	
		$data['tablename'] 			= 'baba';
		$data['target_tablename'] 	= 'core_tb_tables';
		$data['fields'] 			= array('f1');
		$data['target_fields']		= array('id');
		
		$this->tables->create_foreign_key($data);
		die();
	}
	
	public function testdb(){
		//loading the model
		$this->load->model('Table','tables');
		$tableid	= '59';
		$this->tables->transaction_create_physical_table($tableid);
	}

}
	