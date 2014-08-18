<div>
<?php
//default number of rows
	$rows 	= '10';
	$fields = 'Field name';
	$format = 'Format';
	//$div1 	= '<div style = "float:left;"><h3>'.$fields.'</h3>';
	//$div2 	= '<div><h3>'.$format.'</h3>';
	$div1 = '';
	$div2 = '';
	$total = '<div>';
	$size = count($formats);
	
	//loading the form helper
	$this->load->helper("form");
	
	for($i = 0; $i<$rows; $i++){
	//change this into two different div
		//$input1 = array('name' => 'fieldname'.$i);
		$input1 = array('name' => 'data['.$i.'][fieldname]');
		//$input2 = array('name' => 'format'.($i+1));
		$div1 = form_input($input1);
		//$div2 = form_input($input2);
		
		$data = array('0' => '');
		
		//loop to make the combobox of formats
		for($j = 0; $j < $size; $j++){
			$elt = $formats[$j];
			$data[$elt->id] = $elt->name.' ['.$elt->type.'('.$elt->size.')]';
		}
		//$div2 = form_dropdown('format'.$i, $data);
		$div2 = form_dropdown('data['.$i.'][format]', $data);
		$total.= '<div>'.$div1.$div2.'</div>';
	}
	//close the divs

	$total .= '</div>';
	echo $total;


?>
</div>