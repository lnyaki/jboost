<?php

class Test extends TNK_Controller {


	public function view(){
		//loading views
		$data['content'] 	= $this->load->view('test/view_test_links',null,TRUE);
		$this->title("Test page");
		//css & javascript scripts 
		$this->add_css(base_url().'assets/css/test.css');
		$this->create_page($data);
		
	}
	
	public function quizz(){
		//loading views
		$data['content'] 	= $this->load->view('test/view_quizz',null,TRUE);
		$this->title("Quizz page");
		
		//js script
		$data['_scripts']	= $this->load->view('scripts/flashcard_game_script', null, TRUE);
		//css & javascript scripts 
		$this->add_css(base_url().'assets/css/bootstrap-theme.min.css');
		$this->add_css(base_url().'assets/css/bootstrap.min.css');
		$this->add_css(base_url().'assets/css/style-blue.css');
		$this->add_css(base_url().'assets/css/test.css');
		
		$this->add_js(base_url().'assets/js/jquery-2.0.3.min.js');
		$this->add_js(base_url().'assets/js/jquery-1.9.1.js');
		$this->add_js(base_url().'assets/js/test.js');
		
		$this->create_page($data);
	}
	
	public function ajax($elt){
		
		switch($elt){
			case 'quizz' :
				$this->ajax_quizz();
				break;
			default :
				echo 'Unknown ajax function';
		}
	}
	
	private function ajax_quizz(){
		echo "ajax quizz ok<br/>";
		echo $this->input->post('item').'<br/>';
		echo $this->input->post('answer').'<br/>';
	}
}