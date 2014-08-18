<div>
<?php
//temporary string variables. To be later replaced by calls to languages
//elements
	$fieldname 	= 'Field name';
	$format		= 'Format';
	$submit 	= 'Next';
	$addMore 	= 'Add one more field';
	$fieldset 	= 'Add fields';
	$tablename	= $this->input->post('tablename');
//****** creating the form data and attributes ******
//submit button
$button_data = array(	'name' 	=> 'submit_button',
						'value' => $submit);
//button for adding new rows in the form
$button_add_data = array(	'name' 	=> 'adder_button',
							'content'	=> $addMore);
//test
	echo '<h2>[add fields] table : '.$this->input->post('tablename').'</h2>';						
//loading the form helper
	$this->load->helper("form");
//creating the form
	echo form_open('Table_Creation/create_field_group','',array( 'tablename' => $tablename));
	//echo form_fieldset($fieldset);
	echo isset($add_field_view)?$add_field_view :"";
	echo form_button($button_add_data);
	echo form_submit($button_data);
	//echo form_fieldset_close();
	echo form_close();

?>
</div>