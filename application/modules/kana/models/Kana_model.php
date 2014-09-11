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
	
	public function add_stats($data){
		if(!isset($data['kana'])){
			return 'ERR : [Add_stats] No kana was given as argument.';
		}
		
		if(!isset($data['right'])){
			$data['right'] = 0;
		}

		if(!isset($data['wrong'])){
			$data['wrong'] = 0;
		}
		
		$total = $data['right'] + $data['wrong'];
		
		$fields = array($data['right'],$data['wrong'], $total, $data['kana']);
		
		$sql	=  ' update '.$this::main_table.' set';
		$sql	.= ' right = (right + ?)';
		$sql	.= ' wrong = (wrong + ?)';
		$sql	.= ' total = (total + ?)';
		$sql	.= ' where kana = ?';
		
		return $this->db->query($sql, $fields);
	}
	
	public function get_list($list){
		
	}
}