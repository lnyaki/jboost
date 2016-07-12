<?php
class Quizz extends TNK_Controller {

	/**************************************************************/
	//                 Page functions
	/*************************************************************/
	public function index(){
		$this->title("Quizz page");
		
		//get email list widget
		$this->load->module("email_list");
		$widget	= $this->email_list->get_widget();
		//$this->add_block($widget,self::RIGHT_BLOCK);
		
		//Load the quizz widget
		$quizz = $this->widget_quizz();
		//center block
		$this->add_block($quizz,self::CENTER_BLOCK);
		
		$this->generate_page();
	}

	/**************************************************************/
	//                 Utility functions
	/*************************************************************/
	//Get quizz items from the db.
	private function load_items($listname){
		//$this->load->model('kana/kana_model');
		//$tmp = $this->Kana_model->get_kana_list($post['list_name']);
		/****************************/
		
		$this->load->model('lists/lists_model_graph','list');
		
		$items	= $this->list->get_kana_list_content($listname);

		echo json_encode($items);
	}
	
	private function add_stats($post,$userID){
		//$this->load->model('kana/kana_model');
		
		//$this->Kana_model->add_stats($post['stats'],$userID);
	}
	

	/**************************************************************/
	//                 Widgets
	/*************************************************************/
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


	/**************************************************************/
	//                 Ajax
	/*************************************************************/
	//Do something or remove function below
	private function load_items2($post){
		echo '{"name":"toto"}';
	}

	public function json(){return '{}';}
	
	public function ajax($elt){
		//The 2 lines below are necessary.When performing an ajax call to a php source, no
		//Neo4j controller is instanciated, therefore, the neo4j library is no loaded. That's
		//why we need to load it manually when it comes to ajax calls.
		$this->load->library('neo4j');
		$this->neo4j->connect();

		switch($elt){
			case 'json' : $this->json();break;
			case 'load_items' 	:
				$this->load_items($this->input->post('list_name'));
				break;

			case 'add_stats'	:
				//only execute if there is a session id (if the user is logged)
				if(isset($_SESSION['id'])){
					$this->add_stats($this->input->post(null,true),$_SESSION['id']);
				}
				else{
					echo "The user is not logged in";
				}
				break;

			default :
				echo 'Unknown ajax function '.$elt;
		}
	}
}