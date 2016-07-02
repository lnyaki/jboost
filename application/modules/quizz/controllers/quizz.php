<?php
class Quizz extends TNK_Controller {
	public function quizz(){
		$this->title("Quizz page");
		
		//get email list widget
		$this->load->module("email_list");
		$widget	= $this->email_list->get_widget();
		$this->add_block($widget,self::RIGHT_BLOCK);
		
		//Load the quizz widget
		$quizz = $this->widget_quizz();
		//center block
		$this->add_block($quizz,self::CENTER_BLOCK);
		
		$this->generate_page();
	}
	
	public function widget_quizz(){
		//js script
		$this->add_js('assets/js/lodash.compat.js');
		//Carefull, the scripts below are order dependent (need to change that later with a js loader)
		$this->add_js('assets/js/Flashcard_test.js');
		$this->add_js('assets/js/Ajax_test.js');
		$this->add_js('assets/js/Quizz_object_test.js');
		
		//add the quizz css
		$this->add_css('assets/css/quizz.css');
		
		//loading script views
		$this->add_script2('flashcard_game_script');
		
		//loading views
		return $this->load->view('test/view_quizz',null,TRUE);
	}
}