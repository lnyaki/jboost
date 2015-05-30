<?php

class DB extends TNK_Controller {
	
	public function kana(){
		$this->load->model('kana/Kana_model');
		$result = $this->Kana_model->get_stats('5');
		echo "<div>Ok</div>";
		print_r($result);
	}
}