
<?php
	if(!$_physical){
		$this->load->helper('form');
		$hidden	= array();
		echo form_open('tables/generate_table');
		echo form_submit('button', 'Generate table');
		echo form_close();
	}
	
?>