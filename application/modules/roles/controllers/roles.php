<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roles extends TNK_Controller {
		
		public function index(){
			$this->load->model('roles_model');
			
			$result = $this->roles_model->get_roles_list();
			print_r($result);
			
			echo " <br/>";
			
			$result = $this->roles_model->get_privileges_list();
			print_r($result);
		}
	
}


