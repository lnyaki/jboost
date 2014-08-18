<?php

class Table_Creation extends TNK_Controller {
		
	public function __construct(){
		parent::__construct();
	}	
	
	public function test_db(){
		$this->load->model('Core_tables');
		$res = $this->Core_tables->display_tables();
		var_dump($res->result());
	}
		
	public function create_table(){
	//checking if we are back from table creation
		$tablename 		= $this->input->post('tablename');
		$table_creation = $this->input->post('creation');

		if ($table_creation && $tablename) {
			$this->load->model('Core_tables');
			
			if($this->Core_tables->create_logical_table($tablename)){
				echo "<h3>table ".$tablename." has been created created</h3>";
			}
			else{
				echo"<h3> failed to create ".$tablename." </h3>";
			}		
		}
		
	//preparing for when static text will be loaded from outside
		$title = 'Create a new table';
	//initializing the data object
		$data['title'] = $title;
	//loading views
		$data['content'] 	= $this->load->view('pages/table_creation/view_create_table','',TRUE);
		$this->create_page($data);
	}
	
	public function create_fields_db(){
	//checking the POST arguments
		$tablename 		= $this->input->post('tablename');
		$data			= $this->input->post('data');
		$fields			= array();
		$fieldname		= 'fieldname';
		
		echo "tablename : ".$tablename;
	//put the good elements from $data into $fields
		if($data){
			$max = count($data);
			for($i = 0; $i<$max; $i++) {
				if($data[$i][$fieldname] != ''){
					array_push($fields,$data[$i]);
				}
			}
		}
	
	$result = '';
	//if the 'tablename' argument was initialized
		if($tablename && $data){
			$this->load->model('Core_tables','tables');
			
			//create the table
			$this->tables->create_logical_table($tablename);
			
			//get the id of the table
			$tableID = $this->tables->get_table_id($tablename);
			//if there's an entry for that table, add fields
			if($tableID){
				$result = $this->tables->create_fields($tableID, $fields);
			}
			else{
				$result = 'La table d\'id '.$tableID.' n\'existe pas.';
			}
			echo $result;
		}
		else{
			echo 'data or tablename not set';
		}
	}
	
	public function add_fields(){
	//preparing for when static text will be loaded from outside
		$title = 'Add fields';
	//initializing the data object
		$data['title'] = $title;
		
	//load format data from db
		$this->load->model('Core_tables');
		$data2['formats'] = $this->Core_tables->get_formats();
	//loading views
		$data2['add_field_view'] = $this->load->view('pages/table_creation/view_add_fields_content',$data2,TRUE);
		$data['content'] 	= $this->load->view('pages/table_creation/view_add_fields',$data2,TRUE);
		$this->create_page($data);
	}
	
	public function add_format(){
	//preparing for when static text will be loaded from outside
		$title = 'Add format';
	//initializing the data object
		$data['title'] = $title;
	//loading views
		$data['content'] 	= $this->load->view('pages/table_creation/view_add_format','',TRUE);

		$this->create_page($data);
	
	}

	public function select_existing_format(){
	//preparing for when static text will be loaded from outside
		$title = 'Select format';
	//initializing the data object
		$data['title'] 		= $title;
	//loading views
		$data['content'] 	= $this->load->view('pages/table_creation/view_select_existing_format','',TRUE);

		$this->create_page($data);
	}
	
	//page that lets the user create fields group
	public function create_field_group(){
	//checking the POST arguments
		$tablename 		= $this->input->post('tablename');
		$data			= $this->input->post('data');
		$fields			= array();
		$fieldname		= 'fieldname';
		
		echo "tablename : ".$tablename;
		
	//put the good elements from $data into $fields
		if($data){
			$max = count($data);
			for($i = 0; $i<$max; $i++) {
				if($data[$i][$fieldname] != ''){
					array_push($fields,$data[$i]);
				}
			}
		}
//test
	var_dump($fields);

	//get all the group types
		$this->load->model('Core_tables','table');
		$data['grouptypes']	= $this->table->get_fieldgroup_params();
		
	//preparing for when static text will be loaded from outside
		$title 				= 'Create field group';
	//initializing the data object
		$data['title'] 		= $title;
		$data['_fields']	= $fields;
		$data['tablename']	= $tablename;
	//loading views
		$data['content'] 	= $this->load->view('pages/table_creation/view_double_multilist',$data,TRUE);

		$this->create_page($data);		
	}
	
	//create a new groupfield in db (with fields in it)
	public function create_field_group_db(){
		//get post data
		$_table				= $this->input->post('tablename');
		$_fields			= $this->input->post('fields');
		$_type				= $this->input->post('group_type');
		$_fieldgroup_name 	= $this->input->post('fieldgroup_name');
		
		//test
		var_dump($_fields);
		echo "table name : ".$_table."<br/>";
		echo "group type : ".$_type."<br/>";
		echo "fieldgroup name : ".$_fieldgroup_name."<br/>";
		//initialize data
		$data = array();
		
		$this->load->model('Core_tables','table');
		//we create the empty fieldgroup, and return the id
		$res 	= $this->table->create_field_group($_table, $_fields, $_type, $_fieldgroup_name);
		echo "Result : ".$res;
	}
	
	
	//create a table, with its fields and groupfields
	public function create_full_table(){
		//get post data
		$_table				= $this->input->post('tablename');
		$_table_description	= $this->input->post('table_description');
		$_fields			= $this->input->post('fields');
		$_type				= $this->input->post('group_type');
		$_fieldgroup_name 	= $this->input->post('fieldgroup_name');
		
		//test
		var_dump($_fields);
		echo "table name : ".$_table."<br/>";
		echo "group type : ".$_type."<br/>";
		echo "fieldgroup name : ".$_fieldgroup_name."<br/>";
		
	
		//load model
		$this->load->model('Core_tables','table');
		//create table entry and get the id
		$id_table 	= $this->table->create_logical_table($_table, ($_table_description)?$_table_description:'');
		//process the fields because they have special formats
		var_dump($_fields);
		$_fields 	= $this->processCSFields($_fields);
		var_dump($_fields);
		//get pure field names from the fields array
		$fieldnames	= $this->extract_from_array($_fields, 'name');
		echo 'pure fields<br/>';
		var_dump($fieldnames);
		//create the fields for this table
		$this->table->create_fields($id_table, $_fields);
		//get the id of all the fields for this table
		$fields_id	= $this->table->get_fields_id($id_table, $fieldnames);
		$fields_id	= $this->extract_from_array($fields_id, 'id');
		echo 'object array<br/>';
		var_dump($fields_id);
		
		
		//create the empty fieldgroup
		$this->table->create_field_group($id_table, $fields_id, $_type, $_fieldgroup_name);
		//create the fields for the fieldgroup
		
		//test
		echo "table id : ".$id_table.'<br/>';
		echo 'all ok';
		
	}
	
	//display a table
	public function table($tablename){
		//preparing for when static text will be loaded from outside
		$title = $tablename;
	//initializing the data object
		$data['title'] = $title;
		
	//load format data from db
		$this->load->model('Core_tables','table');
		//$data['fields'] = $this->table->get_table_fields($tablename);
		$data['fields'] = $this->table->display_single_table($tablename);
		
	//loading views
		var_dump($data['fields']);
		die();
		
		$data['content'] 	= $this->load->view('pages/table_creation/view_add_fields',$data2,TRUE);
		$this->create_page($data);
	}
	
	
	/****************************************************************
	*  Private functions
	* 
	*****************************************************************/
	//process $fields array, for fields that contain comma separeted values
	private function processCSFields($fields){
		$retour	= array();
		$max 	= count($fields);
		for($i = 0; $i<$max; $i++){
			$content	= preg_split('/;/', $fields[$i]);
			$tab 		= array('name' => $content[0], 'ref_format' => $content[1]);
			
			array_push($retour, $tab);
		}
		
		return $retour;
	}
	
	//extract the specified element from an array of arrays
	private function extract_from_array($array,$item){
		$max	= count($array);
		$tab	= array();
		for($i=0;$i<$max;$i++){
			$tmp = $array[$i];
			if(is_object($tmp)){
				array_push($tab, $array[$i]->$item);
			}
			else if(is_array($tmp)){
				array_push($tab, $array[$i][$item]);
			}
		}
		return $tab;
	}
}
	