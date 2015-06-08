<?php

class DB extends TNK_Controller {
	
	public function kana(){
		$this->load->model('kana/Kana_model');
		$result = $this->Kana_model->get_stats('5');
		echo "<div>Ok</div>";
		print_r($result);
	}
	
	public function add_email(){
		$email = "visiteur@cool.com";
		/*
		$this->load->model('email_list/Email_list_model','email');
		$ok = $this->email>add_email(array('email' => $email, 'list_ref' => '1'));
		*/
		
		$this->load->model('email_list/Email_list_model');
		$ok = $this->Email_list_model->add_email(array('email' => $email, 'list_ref' => '1'));
		
		if($ok){
			echo "Ajout de l'email $email : OK!";
		}
		else{
			echo "Ajout de l'email $email : **** KO ****";
		}
	}
}