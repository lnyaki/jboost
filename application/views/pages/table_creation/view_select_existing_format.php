<div>
<?php
//labels
	$fieldset 	= 'Select format';
	$select		= 'Select : ';
	$value		= 'Validate';
//element name
	$for 		= 'format_selection';
	$button		= 'button';
//form element data
	$data	 	= array('name' => $for);
	$data_submit	= array('name' => $button,
							'value' => $value);
 //loading the form helper
	$this->load->helper("form");

	echo form_open();
	echo form_fieldset($fieldset);
	echo form_label($select, $for);
	echo form_input($data);
	echo form_submit($data_submit);
	echo form_fieldset_close();
	echo form_close();

?>