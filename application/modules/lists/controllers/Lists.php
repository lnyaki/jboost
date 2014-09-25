<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lists extends TNK_Controller {

	public function index(){
		$this->load->model('kana/Kana_model','model');
		$lists = $this->model->get_kana_lists();
		
		$this->load->helper('my_array');

		
		$data	= array();
		$table = '';
		
		if($lists){
			//the first element of the index is the list of fields
			$thead = html_table_head($lists[0]);
			
			//the second element is the rows
			$tbody	= html_table_body($lists[1],'','',array(base_url().'list/',2));
			
			//set up the class of the table 
			$table_class = 'table condensed';
			
			$data['content'] = $this->load->view('lists/list_table_view',array('_thead' => $thead, '_tbody' => $tbody, '_table_class' => $table_class),TRUE);
		}
		else{
		//output warning or something
		}
		
		$this->create_page($data);
	}		
}
	