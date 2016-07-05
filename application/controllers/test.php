<?php
use Everyman\Neo4j;
class Test extends TNK_Controller {

	//Get quizz items from the db.
	private function load_items($post){
		$this->load->model('kana/kana_model');
		$tmp = $this->Kana_model->get_kana_list($post['list_name']);

		echo json_encode($tmp);
	}
	
	//Do something or remove function below
	private function load_items2($post){
		echo "INFO: in load_items2. Should now call some Neo4J";
	}

	
	public function ajax($elt,$elt2 = "arg2"){
		
		switch($elt){
			case 'quizz' :
				echo "ERR: Shouldn't come here. Argument should be 'load_items'";
				break;

			case 'load_items' 	:
				$this->load_items($this->input->post(null,true));
				break;
			
			case 'load_items2'	:
				$this->load_items2($this->input->post(null,true));
			case 'add_stats'	:
				//only execute if there is a session id (if the user is logged)
				if(isset($_SESSION['id'])){
					$this->add_stats($this->input->post(null,true),$_SESSION['id']);
				}
				else{
					echo "The user is not logged in";
				}
				break;
			
			case 'test_ajax' :
				$this->test_ajax();
				break;
			default :
				echo 'Unknown ajax function '.$elt;
		}
	}

	private function ajax_quizz(){
		echo $this->input->post('item').'<br/>';
		echo $this->input->post('answer').'<br/>';
	}
}




