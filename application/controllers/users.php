<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends TNK_Controller {
	
	function index(){
		echo "<div> ffs </div>";
	}
	
	function profile($username){
		$data['content'] = "<div> Hello, user profile $username</div>";
		$this->create_page($data);
	}
	
	function login(){
		$this->load->library('form_validation');
		$data['content'] = $this->load->view('users/login.php',null,true);
		$this->create_page($data);
	}
	
	function register(){
		$data['content']	= $this->load->view('users/register.php',null,true);
		$this->create_page($data);
	}
	
	function registerlogin(){
		$data['content']	= $this->load->view('users/register_login.php',null,true);
		$this->create_page($data);
	}
	
	function process_registration(){
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->form_validation->set_rules('user', 'Username', 'trim|required');
		$this->form_validation->set_rules('pass1', 'Password', 'required');
		//$this->form_validation->set_rules('pass2', 'Password Confirmation', 'required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');

			echo $this->input->post('user')."<br/>";
			echo $this->input->post('pass1')."<br/>";
			///echo $this->input->post('pass2')."<br/>";
			echo $this->input->post('email')."<br/>";
		if ($this->form_validation->run() == FALSE)
		{
			
			echo "NO SUCCESS";
			
			//$this->load->module('users');
			//$this->users->register();
			$this->load->helper('url');
			//redirect('register');
		}
		else
		{
			echo "SUCCESS";
			$this->load->model('users_model');
			/*$success = $this->users_model->add_user(array('username' 	=> $this->input->post('user')
												,'email'	=> $this->input->post('email')
												,'password'	=> $this->input->post('pass1')));*/
			$success = 1;
			if($success > 0){
			//hydrate session
			$result = $this->users_model->get_user(array('email' => $this->input->post('email')),'email');
			$_SESSION['username'] 	= $result->username;
			$_SESSION['email']		= $result->email;
			$_SESSION['id']			= $result->id;
			//print_r($_SESSION);
			redirect('/test/quizz');
			}
			//$this->load->view('formsuccess');
		}
	}

	function process_login(){
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		
		//form validation elements
		$this->form_validation->set_rules('email', 'E-mail', 'trim|required');
		$this->form_validation->set_rules('pass', 'Password', 'required');
		
		if ($this->form_validation->run() == FALSE){
			echo "login form validation : FAIL";
		}
		else{
			echo "login form validation : success";
			
			$this->load->model('users_model');
			$result = $this->users_model->get_user(array('email' => $this->input->post('email')),'email');
			$_SESSION['username'] 	= $result->username;
			$_SESSION['email']		= $result->email;
			$_SESSION['id']			= $result->id;
			redirect('/test/quizz');
		}
		
	}
}