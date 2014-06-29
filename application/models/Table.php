<?php
class Table extends CI_Model{

	public function list_tables(){
		$this->load->database('default');
		$this->db->select('id, name, description, encoding, type');
		$this->db->from('core_tb_tables');
		$query = $this->db->get();
		
		return $query->result();
	}
	
	
	public function transaction_load_table($tableId){
		$this->load->database('default');
		$tab	= array();
		//start the transaction
		$this->db->trans_start();
			//getting fields groups for this table
			$tab['_fieldgroups_id']	= $this->get_fieldgroups_id($tableId);
			//getting the table fields
			$tab['_fields']			= $this->get_table_fields($tableId);
			//getting fieldgroups content (the actual fields)
			$tab['_fieldgroups']	= $this->get_fieldgroups($tab['_fieldgroups_id']);
		$this->db->trans_complete();
		
		return $tab;
	}
	
	//generate the physical table
	public function transaction_create_physical_table($tableid){
		$this->load->database('default');
		$this->load->dbforge();
		//get tablename
		$tablename	= $this->get_table_name($tableid);
		//get fields
		$fields		= $this->get_table_fields($tableid);
		//get fieldgroups
		$fg_ids			= $this->get_fieldgroups_id($tableid);
		$fieldgroups	= $this->get_fieldgroups($fg_ids);
	
		//prepare the fields
		$fields_to_create	= array();
		foreach($fields as $elt){
			if(strtoupper($elt->type)=="VARCHAR" || strtoupper($elt->type)=="CHAR" || strtoupper($elt->type)=="TEXT"){
				$fields_to_create[$elt->field] = array(	'type' => $elt->type,
														'constraint' => $elt->size);
			}
			else if(strtoupper($elt->type)=="INT" || strtoupper($elt->type)=="BIGINT" || strtoupper($elt->type)=="MEDIUMINT"
					|| $elt->type=="SMALLINT" || $elt->type=="TINYINT"){
				$fields_to_create[$elt->field] = array(	'type' => $elt->type,
														'constraint' => $elt->size,
														'unsigned' => FALSE);
			}
			else{
				$fields_to_create[$elt->field] = array(	'type' 	=> $elt->type,
														'constraint' => $elt->size);
			}
			
		}
		//add the fields
		$this->dbforge->add_field($fields_to_create);
		
		//add keys
		//$this->dbforge->add_key(array('f1', 'f2'), TRUE);
		$this->dbforge->add_key('f1', true);
		$this->dbforge->add_key('f2');
		//create the full table
		$this->dbforge->create_table($tablename);
		//$this->db->trans_start();
			
		//$this->db->trans_complete();
	}
	
	//return the name of the table
	public function get_table_name($tableid){
		$this->load->database('default');
		$table	= 'core_tb_tables';
		$this->db->select('name');
		$this->db->from($table);
		$this->db->where('id', $tableid);
		$res 	= $this->db->get();
		$res	= $res->row();
		
		return $res->name;
	}
	
	//gets all the fields of a table
	public function get_table_fields($tableid){
		$table 			= 'core_tb_fields_v';
		$this->load->database('default');
		
		$this->db->select('table_name, field, format, type, size');
		$this->db->from($table);
		$this->db->where('table_id', $tableid);
		
		$res = $this->db->get();
		return $res->result();
	}
	
	
	//returns all the ids of the fieldgroups related to this table
	public function get_fieldgroups_id($tableid){
		$this->load->database('default');
		$table1	= 'core_tb_fieldgroup-l-fields';
		$table2	= 'core_tb_fields';
		
		//request
		$this->db->select('fg.ref_fieldgroup as id');
		$this->db->distinct();
		$this->db->from($table1.' as fg, '.$table2.' as f');
		$this->db->where('f.ref_table = '.$tableid);
		$this->db->where('fg.ref_field = f.id');		
		$res	= $this->db->get();

		return $res->result();
	}
	
	//returns the fields contained in those fieldgroups
	public function get_fieldgroups($fg_ids){
		$this->load->database('default');
		$table1	= '';
		$res	= array();
		foreach($fg_ids as $id){
			$res[$id->id]	= $this->get_fieldgroup($id->id);	
		}		
		return $res;
	}
	
	//return the fields contained in that fieldgroup
	public function get_fieldgroup($fg_id){
		$this->load->database('default');
		$table1	= 'core_tb_fieldgroup-l-fields';	
		$table2	= 'core_tb_fields';
		$table3	= 'core_tb_format';
		$table4	= 'core_tb_format_param';
		$table5 = 'core_tb_fieldgroup';
		$table6 = 'core_tb_fieldgroup_param';
		
		$this->db->select('fg2.name as fieldgroup, f.name as field, fo.name as format, fop.name as type, fo.size, fgp.name as fg_type');
		$this->db->from($table1.' as fg, '.$table2.' as f, '.$table3.' as fo, '.
			$table4.' as fop, '.$table5.' as fg2, '.$table6.' as fgp');
		$this->db->where('fg.ref_fieldgroup = '.$fg_id);
		$this->db->where('fg.ref_field = f.id');		
		$this->db->where('f.ref_format = fo.id');	
		$this->db->where('fo.ref_format_param = fop.id');	
		$this->db->where('fg.ref_fieldgroup = fg2.id');	
		$this->db->where('fg2.ref_fieldgroup_param = fgp.id');	
		
		$res = $this->db->get();
		//$this->db->last_query();
		return $res->result();
	}
	
	//return the possible data types (varchar, char, etc)
	public function get_data_types(){
		$this->load->database('default');
		$table 	= 'core_tb_format_param';
		
		$this->db->select('id, name');
		$this->db->from($table);
		$res	= $this->db->get();
		
		return $res->result();
	}
	
	//create constraints in db (unique, etc)
	public function create_constraints($fieldgroups){
		$this->db->trans_start();
		foreach($fieldgroups as $elt) {
			$this->create_constraint($elt);
		}
		$this->db->trans_complete();
	}
	
	//create a constraint on a fieldgroup, in db
	public function create_constraint($fieldgroup){
		
	}
	
	//create a unique key in your table (primary, secondary)
	public function create_unique_key($table, $fieldgroup, $constraint_name, $primary){
		$this->load->database('default');
		$query	= '';
		
		//create a comma separated list of fields
		$fieldstring = implode(',', $fieldgroup);
	
		//NOT SECURE I THINK, BUT COULDN'T DO OTHERWISE

		//different query for primary or secondary key
		if($primary){
			//query template
			$query		= "ALTER TABLE {$table} ADD CONSTRAINT {$constraint_name} PRIMARY KEY ({$fieldstring})";
		}
		else{
			//query template
			$query		= "ALTER TABLE {$table} ADD CONSTRAINT {$constraint_name} UNIQUE ({$fieldstring})";
		}
		//query
		$resutl	= $this->db->query($query);
	}
	
	
	//create a new format in db
	public function create_format($name, $type, $length, $description){
		$this->load->database('default');
		$table = 'core_tb_format';
		//create request
		$data 	= array('name' 				=> $name,
						'description' 		=> $description,
						'ref_format_param'	=> $type,
						'size'				=> $length);
		$this->db->insert($table, $data);
	}
	
	//create a foreign key on your table, in db
	public function create_foreign_key($fk_data){
		$this->load->database('default');
		
		if(isset($fk_data['fk_name'])){
			$query	 = 'ALTER TABLE '.$fk_data['tablename'].' ADD CONSTRAINT '.$fk_data['fk_name'];
			$query 	.= 'FOREIGN KEY '.$fk_data['fk_name'].'('.implode(',',$fk_data['fields']).') ';
			$qurey	.= 'REFERENCES '.$fk_data['target_tablename'].' ('.implode(',',$fk_data['target_fields']).')';
		}
		else{
			$query	 = 'ALTER TABLE '.$fk_data['tablename'].' ADD FOREIGN KEY ';
			$query 	.= '('.implode(',',$fk_data['fields']).') ';
			$query	.= 'REFERENCES '.$fk_data['target_tablename'].' ('.implode(',',$fk_data['target_fields']).')';
		}
		
		$this->db->query($query);
			
	}
	
	public function join_test2(){
		$join_table1	= 'core_tb_tables';
		$join_table2	= 'core_tb_fields';
		$this->load->database('default');
		
		$this->db->select('t1.name as tab, t2.name as field');
		$this->db->from($join_table1.' as t1');
		$this->db->from($join_table2.' as t2');
		$this->db->where('t1.id = 59');
		$this->db->where('t1.id = t2.ref_table');
		/*
		$sql  = 'SELECT t1.id as tid, t1.name as tab, t2.name as field ';
		$sql .= 'FROM core_tb_tables as t1, core_tb_fields as t2 ';
		$sql .= 'WHERE t1.id = 59 AND t1.id = t2.ref_table';
		
		$res = $this->db->query($sql);
		var_dump($res->result());*/
		
		$query = $this->db->get();
		echo "last query <br/>";
		echo $this->db->last_query();
		var_dump($query->result());
		
	}
	
	public function join_test(){
		$table 			= 'core_tb_fields';
		$join_table1	= 'core_tb_format';
		$join_table2	= 'core_tb_format_param';
		$this->load->database('default');
		
		$sql = 'SELECT a.name as format, a.size, b.name as type FROM core_tb_format as a, core_tb_format_param as b
				WHERE a.ref_format_param = b.id';
		
		//$sql = 'SELECT name, size FROM core_tb_format';
		$res = $this->db->query($sql);
		
		//$res	= $this->db->get();
		
		var_dump($res->result());
		echo $res->result();
	}
	
}
	