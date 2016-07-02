<?php

class Fixture extends TNK_Controller {
	static $fixturePath = "../ignore/jasmine-standalone-2.4.1/spec/fixtures/";
	
	public function index($fixtureName){
		echo "Fixture $fixtureName";
		//loading views
		return $this->load->view($fixturePath.$fixtureName.html,null,TRUE);
	}
	
	public function quizz_fixture(){
		//loading views
		return $this->load->view('../../ignore/jasmine-standalone-2.4.1/spec/fixtures/quizz_fixture.html',null,FALSE);
	}
}
