<?php

class Test extends TNK_Controller {


	public function view(){
		//loading views
		$data['content'] 	= $this->load->view('test/view_test_links',null,TRUE);
		$this->title("Test page");
		
		$this->create_page($data);
		
	}
	
	public function tain(){
		echo "<div>tain</div>";
	}
	
	public function quizz(){
		//loading views
		$data['_content']		= $this->load->view('test/view_quizz',null,TRUE);
		//$data['_left_aside']	= "hello je suis toto";
		$data['_right_aside']	= "hello je suis toto2";
		$data['content']	= $this->load->view('templates/content.php',$data,TRUE);
		
	
		//$data['content'] 	= $this->load->view('test/view_quizz',null,TRUE);
		$this->title("Quizz page");
		
		//js script
		$data['_scripts']	= $this->load->view('scripts/flashcard_game_script', null, TRUE);
		
		$this->add_css(base_url().'assets/js/TOTO.css');
		
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