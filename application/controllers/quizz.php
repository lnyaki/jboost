<?php

class Quizz extends TNK_Controller {
	
	public function quizz(){
		//js script
		$this->add_js('assets/js/lodash.compat.js');
		//be careful, the scripts below are order dependent (need to change that later
		//with a js loader)
		$this->add_js('assets/js/Flashcard_test.js');
		$this->add_js('assets/js/Ajax_test.js');
		$this->add_js('assets/js/Quizz_object_test.js');
		//$this->add_js('assets/js/test.js');
		
		//add the quizz css
		$this->add_css('assets/css/quizz.css');
		
		//get email list widget
		$this->load->module("email_list");
		$widget	= $this->email_list->get_widget();
		$this->add_block($widget,self::RIGHT_BLOCK);
		
		//loading views
		$block			= $this->load->view('test/view_quizz',null,TRUE);
		
		//loading script views
		$quizz_script 	= $this->load->view('scripts/flashcard_game_script', null, TRUE);
		$this->add_script($quizz_script);
		
		//center block
		$this->add_block($block,self::CENTER_BLOCK);
		
		$this->title("QuizPage");
		
		$this->generate_page();
	}
	
	private function load_items($post){
		$this->load->model('kana/kana_model');
		$tmp = $this->Kana_model->get_kana_list($post['list_name']);

		echo json_encode($tmp);
	}
	
	private function load_items2($post){
		echo "INFO: in load_items2. Should now call some Neo4J";
	}
	
	public function add_stats($post,$userID){
		$this->load->model('kana/kana_model');
		
		//$this->Kana_model->add_stats($post['stats'],$userID);
	}
	
	public function test1($elt,$elt2){
		echo "ELT : $elt<br/>";
		echo "ELT2 : $elt2<br/>";
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
	
	public function domain(){
		$this->load->model('roles/roles_model','role');
		
		echo $this->role->get_domain_id('Privileges');
	}
	
	public function test_neo4j(){
		$this->load->library('everyman');		
		$client = new Everyman\Neo4j\Client('localhost', 7474);
		$keanu = new Everyman\Neo4j\Node($client);
		
		//$client->getTransport()->useHttps()->setAuth('neo4j', 'decaloteur');
		$client->getTransport()->setAuth('neo4j', 'decaloteur');
		
 		//print_r($client->getServerInfo());
		//create a node
		$node = $client->makeNode();
		$node->setProperty('name', 'Roronoa Zorro');
		$node->save();
		
		echo "NodeID : ".$node->getId();
		$this->generate_page();
	}
	public function test_security(){
		$this->load->library('View_generator');
		$this->load->library('roles/Security');
		
		$this->security->set_page_restriction('Lists','comment');
		$this->security->set_page_restriction('Lists', 'vote');
		
		$this->security->load_user_privileges('5');
		
		$view;
		if($this->security->has_access_to_page()){
			$view = '<p> Access OK!';
		}
		else{
			$view = '<p> Forbidden access';
		}
		show_404('Hey jude!');
		
		$this->add_block($view);
		$this->generate_page();
	}
	
	private function test_ajax(){
		echo "Appel reçu. Ok.";
		$data = $this->input->post('data');
		
		if($data and is_array($data)){
			foreach($data as $elt){
				echo $elt.'<br/>';
			}
		}
		else{
			echo "Data not set or not an array.";
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
		echo $this->input->post('item').'<br/>';
		echo $this->input->post('answer').'<br/>';
	}
	
	public function dom(){
		
		//load the js
		$this->add_js('assets/js/Ajax_test.js');
		$this->add_js('assets/js/website.js');
		
		
		//add the script for the widget
		$this->add_script2('domain_creation_click_function2');

		$this->generate_page();
	}
	
	public function ajax_test(){
		$this->add_js('assets/js/Ajax_test.js');
		$this->add_js('assets/js/website.js');
		//$this->add_script2('ajax_test.php');
		$this->add_script2('domain_creation_click_function2.php');	
		$this->generate_page();
	}
	
	public function ajax_test_execution(){
		echo "Ajax test OK";
	}
	public function charts(){
		//create charts
		$this->add_js('assets/js/highcharts.js');
		$view 	=	$this->load->view('test/charts',null,TRUE);
		//echo "<div>Hello charts</div>";
		//center block
		$this->add_block($view,self::CENTER_BLOCK);
		
		$this->title("Charts page");
		
		$this->generate_page();
	}
	
	public function modal(){
		//$this->add_js('assets/js/website.js');
		$this->add_js('assets/js/website.js');
		
		$view 	= $this->load->view('test/modal',null,true);
		$alert	= $this->load->view('test/alerts',null,true);
		
		$this->add_block($view,self::CENTER_BLOCK);
		$this->add_block($alert,self::CENTER_BLOCK);
		
		$this->add_script2('test_alerts');
		
		$this->generate_page();
	}
	
	public function alert(){
		$this->add_js('assets/js/website.js');
		$this->add_css('assets/css/website.css');

		$alert	= $this->load->view('test/alerts',null,true);
		$this->add_block($alert,self::CENTER_BLOCK);

		$this->add_script2('test_alerts');

		$this->generate_page();
	}
	
	public function view_generator(){
		$this->load->library('View_generator');
		
		//create the array manualy, for now
		$rows = array(
				array('id'=> '1', 'First Name' => 'Alice', 'Last Name' => 'Fox', 'Job' => 'Entrepreneur'),
				array('id'=> '2', 'First Name' => 'Barra', 'Last Name' => 'Brow', 'Job' => 'Computer Scientist'),
				array('id'=> '3', 'First Name' => 'Charles', 'Last Name' => 'Manik', 'Job' => 'Air Pilot')
		);
		
		$toIgnore	= array();
		
		//Initialise the links configuration array
		$prefix = 'mysite/prefix';
		$links 	= array();

		$links = $this->view_generator->create_row_link($links,2,array(2),$prefix);
		$links = $this->view_generator->create_row_link($links,3,array(1,4),$prefix);
		

		//Prepare the additional array element to add in the html table
		$elt_config1 	= array('name'		=> array(2)
								,'value'	=> 'Toto'
								,'id'		=> array(2,1)
								);
		
		
		$tableConfig 	= array();
		$tableConfig[]	= $this->view_generator->form_element_configuration(View_generator::CHECKBOX,$elt_config1,'Test label','New Column');
		$view 			= $this->view_generator->generate_array($rows,null,$links,null,$tableConfig,'superArray');	
		
		//ensuite, creéer un bouton qui va prendre les rows sélectionnés (lui donner l'id du table)
		$buttonInit = array('content'	=> 'Update privileges'
							,'name'		=> 'buttonPrivileges'
							,'value'	=> 'justAbutton'
							,'class'	=> 'btn btn-success'
							,'id'		=> 'superButton');
		$button = $this->view_generator->generate_form_element($buttonInit,View_generator::BUTTON);
		$this->add_js('assets/js/Ajax_test.js');
		$this->add_script('<script>var click_array = "superArray";var click_button = "superButton";</script>');
		$this->add_script2('click_function_test');
		$this->add_block($view,self::CENTER_BLOCK);
		$this->add_block($button,self::CENTER_BLOCK);
		
		//js script
		$this->add_js('assets/js/lodash.compat.js');
		
		$this->generate_page();
	}

	public function test_items(){
		$this->load->model('Lists/Lists_model','list');
		
		$item = 'toto';
		
		echo $this->list->smart_add_plain_item($item);
	}
}




