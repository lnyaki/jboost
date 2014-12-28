<?php

class Test extends TNK_Controller {


	public function view(){
		//loading views
		$data['content'] 	= $this->load->view('test/view_test_links',null,TRUE);
		$this->title("Test page");
		
		$this->create_page($data);
		
	}
	
	public function page(){
		//js script
		$this->add_js('assets/js/lodash.compat.js');
		$this->add_js('assets/js/test.js');
		$this->add_js('assets/js/test-page.js');
		
		//get email list widget
		$this->load->module("email_list");
		$widget = $this->email_list->get_widget();
		$widget2 = "<h2> Hello widget</h2>";
		$this->add_block($widget,self::RIGHT_BLOCK);
		$this->add_block($widget2,self::RIGHT_BLOCK);
		
		//center block
		$block = "<div> Hello world!</div>";
		$block2 = "<h3> Go belgium</h3>";
		$this->add_block($block2,self::CENTER_BLOCK);
		$this->add_block($block ,self::CENTER_BLOCK);
		
		
		$this->generate_page();
	}
	
	public function quizz(){
		//loading views
		$data['_content']		= $this->load->view('test/view_quizz',null,TRUE);
		//$data['_left_aside']	= "hello je suis toto";
		$this->load->module("email_list");
		$data['_right_aside']	= $this->email_list->get_widget();

		$data['content']	= $this->load->view('templates/content.php',$data,TRUE);
		
	
		//$data['content'] 	= $this->load->view('test/view_quizz',null,TRUE);
		$this->title("Quizz page");
		
		//js script
		$this->add_js(base_url().'assets/js/lodash.compat.js');
		$this->add_js(base_url().'assets/js/test.js');
		$data['_scripts']	= $this->load->view('scripts/flashcard_game_script', null, TRUE);
		
		//$this->add_css(base_url().'assets/js/TOTO.css');
		
		$this->create_page($data);
	}
	
	private function load_items($post){
		$this->load->model('kana/Kana_model');
		$tmp = $this->Kana_model->get_kana_list($post['list_name']);

		echo json_encode($tmp);
	}
	
	public function add_stats($post,$userID){
		$this->load->model('kana/Kana_model');
		
		echo $this->Kana_model->add_stats($post['stats'],$userID);
	}
	
	public function ajax($elt,$elt2 = "arg2"){
		
		switch($elt){
			case 'quizz' :
				echo "HHHHHHello ".$elt;
				echo " ".$elt2;
				//$this->ajax_quizz();
				break;

			case 'load_items' 	:
				$this->load_items($this->input->post(null,true));
				break;

			case 'add_stats'	:
				$this->add_stats($this->input->post(null,true),$_SESSION['id']);
				print_r($_SESSION);
				//$this->add_single_stat(array(array()),$_SESSION['userID']);
				break;
		
			default :
				echo 'Unknown ajax function '.$elt;
		}
	}
	
	//fonction de test
//	public function test($funct = 0,$f2){
	public function tests($funct){
		$this->load->model('kana/Kana_model');
		//あいうえお
		
//	$funct = ''; $f2 = '';
		echo "funct = ".$funct." ";

		$data 			= array();
		$data['id']		= 'あ';
		$data['right']	= '1';
		$data['wrong']	= '1';
		
		switch($funct){
			case '1': echo $this->Kana_model->add_single_stat($data,5);
				break;
			
			case '2': echo $this->Kana_model->update_single_stat($data,5);
				break;
			
			case '0': echo "param par défaut";
				break;

			default :
				echo "fonction par defaut";
		}
	}
	
	private function ajax_quizz(){
		echo $this->input->post('item').'<br/>tete';
		echo $this->input->post('answer').'<br/>';
	}
}