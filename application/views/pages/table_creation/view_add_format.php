<div>
<?php
//labels
	$format 		= 'Format : ';
	$type 			= 'Type : ';
	$length			= 'Length : ';
	$description	= 'Description : ';
	$fieldset 		= 'New format';
	$submit_val 	= 'Validate';
	$variation_val	= 'From existing format';
//form fields names
	$format_name		= 'format';
	$type_name 			= 'type';
	$length_name		= 'length';
	$description_name	= 'description';
	$submit 			= 'submit_button';
	$variation 			= 'variation_button';
	
//data initialization
	$data_format 		= array('name' => $format_name);
	$data_type 			= array('name' => $type_name);
	$data_length 		= array('name' => $length_name);
	$data_description 	= array('name' => $description_name);
	
	$submit_button		= array('name' 	=> $submit,
								'value' => $submit_val);
	$variation_button	= array('name' 	=> $variation,
								'content' => $variation_val);
 //loading the form helper
	$this->load->helper("form");

	echo form_open();
	echo form_fieldset($fieldset);
	echo '<div>';
	echo form_label($format, $format_name);
	echo '<br/>';
	echo form_input($data_format);
	echo '</div>';
	echo '<div>';
	echo form_label($type, $type_name);
	echo '<br/>';
	echo form_input($data_type);
	echo '</div>';
	echo '<div>';
	echo form_label($length, $length_name);
	echo '<br/>';
	echo form_input($data_length);
	echo '</div>';
	echo '<div>';
	echo form_label($description, $description_name);
	echo '<br/>';
	echo form_textarea($data_description);
	echo '</div>';
	echo '<div>';
	echo form_button($variation_button);
	echo form_submit($submit_button);
	echo '</div>';
	echo form_fieldset_close();
	echo form_close();
	
?>
</div>