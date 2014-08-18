<div>
<?php
//temporary string variables. To be later replaced by calls to languages
//elements
	$tableName 	= "Table name : ";
	$submit 	= "Next";
	$fieldset	= 'Create a new table';
//creating the form data and attributes
	$data1 			= array(	'name' 	=> 'tablename',
								'id' 	=> 'tablename',
								'value' => '' );
	
	$button_data 	= array(	'name' 	=> 'submit_button',
								'value' => $submit);
							
	$hidden_fields 	= array(	'creation' => 'y');

//loading the form helper
	$this->load->helper("form");
//creating the form
	//echo form_open('Table_Creation/create_table','',$hidden_fields);
	echo form_open('Table_Creation/add_fields','',$hidden_fields);
	echo form_fieldset($fieldset);
	echo form_label($tableName, "tableNameInput");
	echo form_input($data1);
	echo '<br/>';
	echo form_submit($button_data);
	echo form_fieldset_close();
	echo form_close();
?>
</div>