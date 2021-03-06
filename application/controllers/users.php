<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Neo4j_controller {
	//Display the list of users
	function index(){
		$this->load->model('users_model','users');
		//load data
		//$users = $this->users->get_users();
		$graphUsers = $this->users->get_users_g();
		
		
		
		//load view
		//$user_view	= $this->load->view('users/users_list',array('_users' =>$users),true);
		$user_view_g 	= $this->load->view('users/users_list_g',array('_users' =>$graphUsers),true);
		
		//add the view to the page
		//$this->add_block($user_view,self::CENTER_BLOCK);
		$this->add_block($user_view_g,self::CENTER_BLOCK);

		$this->generate_page();
	}
	
	function profile($username){
		//load sessions library
		$this->load->library('session');
		//load the requiered model
		$this->load->model('users_model');
		$this->load->model('kana/kana_model');
		$this->load->model('roles/roles_model','role');
		

		//load module to access view from other modules
		$this->load->module('roles');
		/************************************************************
		*    			Load data
		//************************************************************/
		//display basic info about the user, for now
		$user_data = $this->users_model->get_user(array('username' => $username),'username');
		//get kana stats
		$_list = $this->kana_model->get_stats($user_data->id);
		//get user privileges
		$privileges = $this->role->get_user_privileges($user_data->id);		
		
		//if there is no user  (TODO : redo this, this is bullshit securitywise)
		if(!$user_data){
			//output text or error
			echo "Error : User $result->username could not be found!";
		}
		
		$data = array('_list' => $_list);
		

		/************************************************
		*    			Loading views
		//************************************************************/
		$stats		= $this->load->view('lists/hiragana_list',$data,TRUE);
		

		$userTitle				= $this->load->view('users/user_title',array('_usertitle' => $user_data->username),true);
		$privileges_view 		= $this->load->view('users/user_privileges',array( '_privileges' => $privileges),true);
		$button_add_privilege	= $this->roles->get_add_privilege_to_user_widget(array('_username' =>$user_data->username));
		//compose page
		$this->add_block($userTitle,self::CENTER_BLOCK);
		$this->add_block($privileges_view,self::CENTER_BLOCK);
		$this->add_block($button_add_privilege,self::CENTER_BLOCK);
		$this->add_block($stats,self::CENTER_BLOCK);

		$this->generate_page();
	}

	//Display the dashboard for users (contains all relevant data for business level)
	public function dashboard(){
		
	}
	
	public function widget_user_privileges($username){
		$this->load->model('roles/roles_model','role');
		$this->load->model('users_model');
		$userdata	= $this->users_model->get_user(array('username' => $username),'username');
		//get user privileges
		$privileges = $this->role->get_user_privileges($userdata->id);		
		
		return $this->load->view('users/user_privileges',array( '_privileges' => $privileges),true);
	}
	
	public function login(){
		$this->load->library('form_validation');
		$data['content'] = $this->load->view('users/login.php',null,true);
		$this->create_page($data);
	}
	
	//we handle the display and the processing in the same function
	public function register($processing = null){
		if($processing <> null){
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');

			$this->form_validation->set_rules('user', 'Username', 'trim|required');
			$this->form_validation->set_rules('pass1', 'Password', 'required');
			$this->form_validation->set_rules('pass2', 'Password Confirmation', 'required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required');
			
			if ($this->form_validation->run() == FALSE){
				$register_view = $this->load->view('users/register.php',null,true);
				$this->add_block($register_view,self::CENTER_BLOCK);
				$this->generate_page();
			}
			else{
				$this->load->model('users_model');
				$this->load->helper('table');
			
				//check if email already exists.
				if( ! $this->users_model->user_exists($this->input->post('email'))){
					$success = $this->users_model->add_user(array('username' 	=> $this->input->post('user')
																,'email'	=> $this->input->post('email')
																,'password'	=> sha1_salt($this->input->post('pass1'))));
			
					if($success > 0){
					//hydrate session
						$result = $this->users_model->get_user(array('email' => $this->input->post('email')),'email');
						$_SESSION['username'] 	= $result->username;
						$_SESSION['email']		= $result->email;
						$_SESSION['id']			= $result->id;
						//print_r($_SESSION);
						redirect('/test/quizz');
					}
				}
				//if user exists, we go back on registration page
				else{
					redirect('/register');
				}
				//$this->load->view('formsuccess');
			}				
		}
		
		$data['content']	= $this->load->view('users/register.php',null,true);
		$this->create_page($data);
	}
	
	function disconnect(){
		$this->load->library('session');
		$this->session->sess_destroy();
		session_destroy();
		redirect(base_url().'test/quizz');
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
		$this->form_validation->set_rules('pass2', 'Password Confirmation', 'required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required');

		/*echo $this->input->post('user')."<br/>";
		echo $this->input->post('pass1')."<br/>";
		///echo $this->input->post('pass2')."<br/>";
		echo $this->input->post('email')."<br/>";
		*/
		if ($this->form_validation->run() == FALSE)
		{
			
			//echo "NO SUCCESS";
			
			//$this->load->module('users');
			//$this->users->register();
			$this->load->helper('url');
			//redirect('register');
			$register_view = $this->load->view('users/register.php',null,true);
			$this->add_block($register_view,self::CENTER_BLOCK);
			$this->generate_page();
		}
		else
		{
			$this->load->model('users_model');
			$this->load->helper('table');
			
			//check if email already exists.
			if( ! $this->users_model->user_exists($this->input->post('email'))){
				$success = $this->users_model->add_user(array('username' 	=> $this->input->post('user')
																,'email'	=> $this->input->post('email')
																,'password'	=> sha1_salt($this->input->post('pass1'))));
			
				if($success > 0){
				//hydrate session
					$result = $this->users_model->get_user(array('email' => $this->input->post('email')),'email');
					$_SESSION['username'] 	= $result->username;
					$_SESSION['email']		= $result->email;
					$_SESSION['id']			= $result->id;
					//print_r($_SESSION);
					//redirect('/test/quizz');
				}
			}
			//if user exists, we go back on registration page
			else{
				redirect('/register');
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
			$this->load->library('session');
			$this->load->model('users_model');
			$this->load->model('roles/roles_model','role');
			$this->load->library('View_generator');
			$this->load->library('roles/Security');
			$this->load->helper('table');
			//we need to check the user's credentials
			$result = $this->users_model->get_user(array('email' 	=> $this->input->post('email')
														,'password'	=> sha1_salt($this->input->post('pass')))
														,'login');
			if($result != null){
				$_SESSION['username'] 	= $result->username;
				$_SESSION['email']		= $result->email;
				$_SESSION['id']			= $result->id;
				
				//using codeigniter session for security reasons
				$raw_privileges		= $this->role->get_user_privileges($result->id);
				$user_privileges	= $this->view_generator->get_sub_arrays($raw_privileges,array(1));
				
				//Load the user privilege (no need to assign anyting to a var, in happens in the background)
				$this->security->load_user_privileges($result->id);

				echo "user ID : ".$result->id; echo "<br/>";
				echo "Raw privileges : ";
				echo "<br/>";
				print_r($raw_privileges);echo "<br/>";
				echo "Privileges : "; echo "<br/>";
				print_r($user_privileges);
				$this->session->set_userdata('username',$result->username);
				$this->session->set_userdata('id',$result->id);
				$this->session->set_userdata('username',$result->username);
				//$this->session->set_userdata('privileges',$user_privileges);

				redirect('/test/quizz');
			}
			//user not found -> invalid credentials (probably)
			else{
				echo "ERR : user not found.<br/>";
				echo 'email : '.$this->input->post('email').'<br/>';
				echo 'password : '.sha1_salt($this->input->post('pass'));
				redirect('/login');
			}
		}
		
	}
}