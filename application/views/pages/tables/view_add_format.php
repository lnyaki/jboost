
<?php

	//initialize data
	$dropdown	= array();
	
	foreach($_types as $type){
		$dropdown[$type->id]	= $type->name;
	}
	
	
	$this->load->helper('form');

	//create a form
	echo form_open('Tables/add_new_format_db');
	//create a fieldset
	echo form_fieldset('Add a new format');
	//name
	echo form_label('Name', 'label_name');
	echo '<br/>';
	echo form_input('format', '');
	echo '<br/>';
	//type
	echo form_label('Type', 'label_type');
	echo '<br/>';
	echo form_dropdown('type', $dropdown);
	echo '<br/>';
	//size
	echo form_label('Size','label_size');
	echo '<br/>';
	echo form_input('size', '');
	echo '<br/>';
	//description
	echo form_label('Description','label_description');
	echo '<br/>';
	echo form_textarea('description','');
	echo '<br/>';
	echo form_submit('submit', 'Add Format');
	echo form_fieldset_close();
	echo form_close();

?>