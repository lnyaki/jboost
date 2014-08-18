<?php
class Core_tables extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	/***********************************************************
	 *                                                         *
	 *					DISPLAY                                *
	 *                                                         *
	 ***********************************************************/
	//returns the id and names of the tables
	public function display_tables(){
		$this->load->database('default');
		$this->db->select('id, name');
		$this->db->from('core_tb_tables');
		$query = $this->db->get();
		
		return $query;
	}
	
	//returns all the info on a table
	public function display_single_table($tablename){
		$this->load->database('default');
		$this->db->select('id, field, Table_name, format');
		$this->db->from('core_tb_fields_v');
		$this->db->where('Table_name', $tablename);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	
	/***********************************************************
	 *                                                         *
	 *				  	 CREATE                                *
	 *                                                         *
	 ***********************************************************/
	//create a new entry in the core_tb_tables table
	public function create_logical_table($tablename, $description = ''){
	//table name of the actual sql table where we need to insert the record
		$myTable = 'core_tb_tables';
	//create request
		$this->load->database('default');
		$data 	= array('name' 			=> $tablename,
						'description' 	=> $description,
						'type'			=> 'physical');
		$this->db->insert($myTable, $data);
		
		return $this->db->insert_id();
	}
	
	
	//create fields in db, for this table
	public function create_fields($tableID, $fields){
		$table = 'core_tb_fields';
		$this->load->database('default');
		
		$max = count($fields);
		for($i = 0; $i<$max; $i++){
			$elt = $fields[$i];
			$data[$i] =	array(	'name' 			=> $elt['name'],
								'ref_format' 	=> $elt['ref_format'],
								'ref_table'		=> $tableID,
								'description'	=> '');
		}
		

		$res = $this->db->insert_batch($table, $data);
		return $res;
	}
	
	
	/* create a group of fields in db
	 * param $table 	: id of the table
	 * param $fields 	: ids of the fields
	 * 
	 */
	public function create_field_group($tableid, $fields, $type, $name){
		$table = 'core_tb_fieldgroup-l-fields';
		$this->load->database('default');
		echo "Table : ".$tableid.'<br/>';
		echo "fieldgroup name : ".$name.'<br/>';
		echo "Type : ".$type.'<br/>';
		echo "Fields : <br/>";
		var_dump($fields);
		echo "tablename : ".$tableid;

		//we first create a fieldgroup entry
		$fieldgroup_id = $this->create_fieldgroup_entry($tableid, $name, $type);
		
		//we then take the id of the fieldgroup and add the fields
		
		//we prepare the fields data to add to the fieldgroup
		$data 	= array();
		$max 	= count($fields);
		for($i = 0; $i<$max; $i++){
			array_push($data,array(	'ref_fieldgroup'	=> $fieldgroup_id,
									'ref_field'			=> $fields[$i]));
		
		}
		
		return $this->db->insert_batch($table, $data);
	}
	
	//create a fieldgroup entry, in table core_tb_fieldgroup
	public function create_fieldgroup_entry($tableid, $name, $type){
		//initialize data
		$table = 'core_tb_fieldgroup';
		$this->load->database('default');
		$data = array(	'name'					=> $name,
						'ref_table'				=> $tableid,
						'ref_fieldgroup_param'	=> $type);
		//perform the insert
		$this->db->insert($table, $data);
		
		return $this->db->insert_id();
	}
	/***********************************************************
	 *                                                         *
	 *						GET                                *
	 *                                                         *
	 ***********************************************************/
	//return the id of a table, based on its name
	public function get_table_id($tablename){
		$table 	= 'core_tb_tables';
		$this->load->database('default');
		$this->db->select('id');
		$this->db->from($table);
		$this->db->where('name', $tablename);
		$res = $this->db->get();
		$res = $res->result();
		
		return (isset($res[0]))?$res[0]->id:FALSE;
	}
	
	//returns all the formats from core_tb_format-v
	public function get_formats(){
		$table = 'core_tb_format_v';
		$this->load->database('default');
		$this->db->select('id, name, size, type');
		$this->db->from($table);
		$res = $this->db->get();
	
		return $res->result();
	}
	
	
	//gets all the fields of a table
	public function get_table_fields($table){
		$table = 'core_tb_fields_v';
		$this->load->database('default');
		
		$this->db->select('id, field, table_name, format');
		$this->db->from($table);
		$res = $this->db->get();
		
		$test = $res->result();
	
		return $res->result();
	}

	//return all the different type of field groups
	public function get_fieldgroup_params(){
		$table = 'core_tb_fieldgroup_param';
		$this->load->database('default');
		
		$this->db->select('id, name');
		$this->db->from($table);
		$res = $this->db->get();
		
		return $res->result();
	}
	
	//return the id of those fields
	public function get_fields_id($tableID, $fields){
		$fields_id	= array();
		$max		= count($fields);
		//get the id of all the fields
		for($i=0;$i<$max; $i++){
			array_push($fields_id, $this->get_field_id($tableID, $fields[$i]));
		}
		//test
		echo "get_fields_id :<br/>";
		var_dump($fields_id);
		
		return $fields_id;
	}
	
	//return the id of the field
	public function get_field_id($tableID, $field){
		$table 		= 'core_tb_fields';	
		//select the id of the field
		$this->db->select('id');
		$this->db->from($table);
		$this->db->where('ref_table', $tableID);
		$this->db->where('name', $field);
		$res = $this->db->get()->result();
		//return the result
		return $res[0];
	}
	
	/***********************************************************
	 *                                                         *
	 *					 DELETE                                *
	 *                                                         *
	 ***********************************************************/
	public function delete_table($tablename){
		
	}
	
	
	public function delete_fields($fields){
		
	}
	
	public function delete_format($data){
		
	}
	
	
	public function add_format($data){
		
	}
	

	/*****************************************************************
	 * 
	 * 					Private functions
	 * 
	 *****************************************************************/

}

?>