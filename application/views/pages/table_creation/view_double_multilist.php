<div>
<?php
//labels
	$add		= 'Add';
	$remove		= 'Remove';
	$value		= 'Validate';
	$fieldset	= 'Select elements';
//element name
	$textarea1	= 'text_area_from';
	$textarea2 	= 'text_area_to';
	$validate	= 'validate';
//form element data
	$data_textarea1	 	= array('name' => $textarea1);
	$data_textarea2		= array('name' => $textarea2);
	$data_button_add	= array('name' => $add, 'content' => $add);
	$data_button_remove	= array('name' => $remove, 'content' => $remove);
	$data_submit	= array('name' => $validate,
							'value' => $value);
							

//put the fields elements into a proper array
	$length 	= count($_fields);
	$fieldList	= array();
	for ($i = 0; $i<$length; $i++){
		$tmp = $_fields[$i];
		$fieldList[$tmp['fieldname'].';'.$tmp['format']] = $tmp['fieldname'].'('.$tmp['format'].')';
	}
							
//turn the db result into a simple array
	$group_types 	= array();
	$l 				= count($grouptypes);

	for($i=0;$i<$l;$i++){
		$tmp 					= $grouptypes[$i];
		$group_types[$tmp->id] 	= $tmp->name;
	}	
		
//take the fields & formats in post and put them in form, as hidden fields
	$hidden = array();
	/*$max 	= count($_fields);
	
	for($i = 0; $i<$max; $i++){
		$tmp = $_fields[$i];
		$hidden['fields['.$i.'][fieldname]']	= $tmp['fieldname'];
		$hidden['fields['.$i.'][format]'] 		= $tmp['format'];
	}
		*/
	
	$hidden['tablename'] = $tablename;
	var_dump($hidden);
	echo "create_field_group tablename : ".$tablename;
 //loading the form helper
	$this->load->helper("form");
//form
	echo form_open('/Table_Creation/create_full_table','',$hidden);
	echo form_fieldset($fieldset);
	echo form_dropdown('fields[]', $fieldList,'', 'multiple');
	echo form_dropdown('group_type',$group_types,'');
	echo form_input('fieldgroup_name');
	echo '<br/>';
	echo form_submit($data_submit);
	echo '<br/>';
	echo '<br/>';
	echo form_textarea($textarea1);
	echo '<div>';
	echo form_button($data_button_add);
	echo form_button($data_button_remove);
	echo '</div>';
	echo form_textarea($textarea1);
	echo '<br/>';
	echo form_submit($data_submit);
	echo form_fieldset_close();
	echo form_close();
	
//handle post elements
$exit 		= false;
$i 			= 0;
$fields 	= array();
$formats 	= array();
$field_name;
$format_name;
$fieldname 	= 'fieldname';
$format 	= 'format';
while (!$exit){
	$field_name 	= $this->input->post($fieldname.$i);
	$format_name 	= $this->input->post($format.$i);

	if(($field_name === FALSE) || ($format_name === FALSE)){
		$exit = TRUE;
	}
	else{
		if($field_name == '' || $format_name == ''){
			$exit = TRUE;
		}
		else{
			array_push($fields, $field_name);
			array_push($formats, $format_name);
		}
	}
	$i++;
}

?>
</div>




