<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Kana_model extends CI_Model{
	const main_table 	= 'kana01';
	
	//call modes
	public static $cm_01	= array('*');
	public static $cm_02	= array('kana','pronounciation','type');
	
	//return 1 hiragana corresponding to the pronounciation
	public function get_hiragana($pronounciation){
		return $this->get_kana($pronounciation, 'h');
	}
	
	//return 1 katakana corresponding to the pronounciation
	public function get_katakana($pronounciation){
		return $this->get_kana($pronounciation, 'k');
	}
	
	//return 1 kana corresponding to the pronounciation
	public function get_kana($pronounciation, $type){
		$this->load->helper('table');
		
		$fields = array($pronounciation);
		

		$sql = 'select '.$cm_02;
		$sql .= ' from '.self::main_table;
		$sql .= ' where pronounciation = ?';
		
		//if the type is initialized, we search on the type.
		//otherwise, we retrieve all records matching the pronounciation
		//regardless of the type (in this case, it will be hiragana and katakana)
		if($type != null){
			$sql .= 'and type = ?';
			$fields.push($type);
		}
		
		return $this->db->query($sql, $fields);
	}
	
	public function get_kana_list($list){
		$fields = array($list);

		$sql = "select list.name 'list_name',kana.id,kana.kana,kana.pronounciation, kana.type";
		$sql .= ' from kana02 as list, kana02_details as details, kana01 as kana';
		$sql .= ' where kana.id = details.kana_ref and details.list_ref = list.id';
		$sql .= ' and list.name = ?';
		
		$query 	= $this->db->query($sql,$fields);
		
		$kana = array();
		
		foreach($query->result() as $res){
			$kana[] = array('item' 	=> $res->kana
							,'id'	=> $res->id
							,'answer' => $res->pronounciation
							);
		}
		return $kana;
	}
	
	public function exists($kana,$userID){
		$table = 'kana01_stats';
		
		$fields = array($kana,$userID);
		
		$sql = "select 1 as found from $table where kana_ref = ? and user_ref = ?";
		$query = $this->db->query($sql,$fields);
		$result = $query->first_row();
		
		$exists = (empty($result))? false: true;
		
		echo "DATA. Kana : ".$kana."  User : ".$userID;
		echo "  RESULT : ".$exists.' ok?';
		print_r($result);
		
		return $exists;
		
	}
	
	public function add_stats($data, $userID){
		$table 	= 'kana01_stats';

		$sql 		= '';
		$fields		= array();
		$queryOK	= true;
		
		foreach($data as $item){
			
			$exists		= $this->exists($item['item'],$userID);
			
			echo "EXIST ".$item['item']." pour user ".$userID.' : '.((int)$exists).'<br/>';
			
			if($exists){
				$queryOK	= $queryOK and $this->update_single_stat($item, $userID);
			}
			else{
				$queryOK 	= $queryOK and $this->add_single_stat($item, $userID);
			}
	
		}
		
		echo ($queryOK)? "Ajout OK": "Problème dans l'ajout<br/>";

		echo "dans add stats";
		
		return $queryOK;
	}
	
	//add a single stat entry.
	public function add_single_stat($data,$userID){
		echo "** Add single stat **";
		
		$table 	= 'kana01_stats';

		if(!isset($data['right'])){
			$data['right'] = 0;
		}
		
		if(!isset($data['wrong'])){
			$data['wrong'] = 0;
		}
		
		$total = $data['right'] + $data['wrong'];


		$fields	= array();
		
		$sql     = "INSERT INTO $table (kana_ref,ok,ko,total,user_ref)";
		$sql	.= " VALUES ( ? ,?,?,?,?)";
			
		print_r($data);

		array_push($fields, $data['item']);
		array_push($fields, $data['right']);
		array_push($fields, $data['wrong']);
		array_push($fields, $total);
		array_push($fields, $userID);

		//return 1;
		return $this->db->query($sql, $fields);
	}
	
	//update a single stat entry
	public function update_single_stat($data,$userID){
		$table 	= 'kana01_stats';
		
		echo "////////////////// update_single_stat ////////////";
		
		if(!isset($data['right'])){
			$data['right'] = 0;
		}
		
		if(!isset($data['wrong'])){
			$data['wrong'] = 0;
		}
		
		$total = $data['right'] + $data['wrong'];
		
		$sql	= "UPDATE $table SET ok = ok + ?, ko = ko + ?, total = total + ?";
		$sql	.= " WHERE kana_ref = ? and user_ref = ?";
		
		$fields	= array();
		array_push($fields, $data['right']);
		array_push($fields, $data['wrong']);
		array_push($fields, $total);
		array_push($fields, $data['item']);
		array_push($fields, $userID);
		
		return $this->db->query($sql, $fields);
	}
	
	public function get_list($list){
		
	}
}