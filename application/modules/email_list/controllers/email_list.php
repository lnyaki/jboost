<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Email_list extends TNK_Controller {
	
	public function get_widget(){
		return $this->load->view('newsletter_view',null,true);
	}
	
	public function add_email(){
		$this->load->model("email_list_model",'model');
		$email 	= $this->input->post('email');
		$list	= $this->input->post('list');
		
		//check that the email is not already in the list, then add.
		if(!$this->model->exists($email,$list)){
			$this->model->add_email(array(	'email' 	=> $email,
											'list_ref'	=> $list
									));
		}
		
		//redirect($this->input->post('redirect'));
	}
}
	