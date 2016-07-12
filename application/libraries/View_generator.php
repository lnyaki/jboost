<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class View_generator{
	//Table head and table body html tags
	const THEAD 		= 'thead';			//table head
	const TBODY 		= 'tbody';			//table body
	
	//Description of css class
	const THCLASS		= 'thead_class';	//css class for the table head
	const TBCLASS		= 'tbody_class';	//css class for the table body
	const TABLECLASS	= 'table_class';	//css class for the table tag
	
	//Modes of composition of html links
	const CONCATENATION	= 'concatenation';	//specify that we want to concatenate fields to create link urls
	
	//Types of constants to use when creating the array that contains the html title of content
	const TITLE			= 'title';
	const TITLE_PREFIX	= 'title_prefix';
	const TITLE_POSTFIX	= 'title_postfix';
	
	//constants for handling html forms generation
	const FORM_ID_ELEMENT	= 'id_element';
	const FORM_DATA			= 'form_data';
	const COLUMN_NAME		= 'column_name';
	const FORM_ELEMENT_TYPE	= 'form_elt_type';
	const TEXTFIELD			= 'textfield';
	const TEXTAREA			= 'textarea';
	const CHECKBOX			= 'checkbox';
	const DROPDOWN			= 'dropdown';
	const RADIO				= 'radio';
	const BUTTON 			= 'button';
	const LABEL				= 'label';
	const MULTILIST			= 'multi_list';
	const ELEMENT_DATA		= 'form_elt_data';
	//constants for form rows generation
	const ROW_WIDTH			= 'row_width';
	const FORM_ELEMENT		= 'form_element';
	//MISC
	const FIELDS			= 'fields';			//The constant 'fields' that will be used in the links array
	const PREFIX			= 'prefix';			//The constant 'prefix' that will be used in the links array
	const POSTFIX			= 'postfix';
	const ARRAY_TITLE		= 'array_title';	//This constant is used as an index in the table that contains the title of an array.
	const ARRAY_TITLE_ROW	= 'array_title_row';//Constant used as index to describe the array field from which the title should be extracted.
	 /**********************************************************************
	 * 
	 *                        PUBLIC API
	 *
	 **********************************************************************/
	public function generate_titled_array($titles,$rows,$toIgnore = array(),$links = null,$classes = array(),$formData = null,$globalID = 'myId'){
		$final_content = '';
		//initialize toIgnore, if null
		$toIgnore = ($toIgnore == null)? array(): $toIgnore;
		
		//Create the title prefix and title postfix variables
		$prefix 	= $titles[self::PREFIX];
		$postfix	= $titles[self::POSTFIX];
		
		if($titles == null){
			$final_content = $this->generate_array($rows,$toIgnore,$links,$classes,null,$globalID);
		}
		//If the titles are set
		else{
			if(isset($titles[self::ARRAY_TITLE]) and $titles[self::ARRAY_TITLE] != ''){
				$final_content .= '<h3>'.$prefix.$titles[self::ARRAY_TITLE].$postfix.'</h3>';
			}
			else if(isset($titles[self::ARRAY_TITLE_ROW])){
				if(count($rows) > 0){
										
					$single_row = (array)$rows[0];
					
					$title_row = $titles[self::ARRAY_TITLE_ROW];
					$title_element = $this->extract_relevant_fields($single_row,array($title_row));
					$title_element = $title_element[0];
					//set the title
					$final_content .= '<h3>'.$prefix.$title_element.$postfix.'</h3>';
					//Ignore this field (it shouldn't be displayed as it is a title)
					if(!in_array($title_element,$toIgnore)){
						$toIgnore[] = $title_row;
					}
				}
			}

			$final_content .= $this->generate_array($rows,$toIgnore,$links,$classes,$formData,$globalID);
		}
		
		return $final_content;
	} 
	public function generate_array($rows,$toIgnore = array(),$links = null,$classes = array(),$formData = null,$arrayID = "dataArray"){
		//Make sure that the $rows are on array form
		$rows = $this->to_array($rows);
		
		//Transform the raw link data into real links
		$links = $this->generate_links($rows, $links);
		$i 		= 0;
		
		if($toIgnore == null){
			$toIgnore = array();
		}
		
		//if the data provided is an empty array, we return
		if(count($rows) == 0){
			return '<p>No data available</p>';
		}
		
		//get the head of the table
		$table_head = $this->generate_table_head($rows[0],$toIgnore,$classes,$formData);
		
		//get the body of the table
		$table_body	= $this->generate_table_body($rows,$toIgnore,$links,$classes,$formData);
		
		$result		= '<table id="'.$arrayID.'" class="table">'.$table_head.$table_body.'</table>';
	
		return $result;
	}
	
	//This function creates an array that contains data about the title that will
	//be used to illustrate other data such as html array or forms.
	public function initialize_array_title($title,$title_row = '',$prefix ='',$postfix = ''){
		$title_array = array();
				
		$prefix = ($prefix == null)?'': $prefix;
		$postfix= ($postfix == null)?'':$postfix;
		$title	= ($title	== null)?'':$title;
		
		$title_array[self::ARRAY_TITLE] 	= $title;
		$title_array[self::ARRAY_TITLE_ROW]	= $title_row;
		$title_array[self::PREFIX]			= $prefix;
		$title_array[self::POSTFIX]			= $postfix;
		return $title_array;
	}
	
	//initializes an array that describes the field link that must be generated
	public function create_row_link($array,$linkfield,$fieldsToUse,$prefix = ''){
		if($array == null){
			$array = array();
		}
		$array[strval($linkfield)] = array('fields' =>$fieldsToUse, 'prefix' => $prefix);
		
		return $array;
	}
	
	//generate links (for tag <a>) based on an array of data.
	public function generate_links($data,$fieldNumbers,$type = self::CONCATENATION){
		$links_array = array();
		
		if(!is_array($data)) {
			message_log('error','[view_generator]Generate_links : The first parameter should be an array.');
		}
		
		//for each row, calculate the link
		foreach($data as $row){
			$length = count($row);
			$fieldIndex = 0;
			$link = '';
			
			$rowLinksArray = array();
			for($i = 0; $i<$length;$i++){
				$fieldIndex	= $i+1;

				if(isset($fieldNumbers[strval($fieldIndex)])){
					$link = $this->generate_single_link($row, $fieldNumbers[strval($fieldIndex)],$type);		
					$rowLinksArray[strval($fieldIndex)] = $link;
				}
			}
			array_push($links_array,$rowLinksArray);
		}
		return $links_array;
	}
	
	//Take an array A of rows, and returns an array B, composed of several sub array B1,B2,...,Bn.
	//Each array Bx contains all the rows which have similar values for certain rows.
	//In other words, this functions take an arrays and separates its content based on some values.
	public function get_sub_arrays($rows,$criteria_fields,$case_sensitive = false){
		$previous_value 	= (count($rows)>0)? implode($this->extract_relevant_fields($rows[0], $criteria_fields)): '';
		$return_array 	= array();
		$local_array 	= array();
		$extracted		= '';

		//Loop on the data array ($rows0).
		foreach ($rows as $row){
			$extracted = implode($this->extract_relevant_fields($row, $criteria_fields));
			//testing if the current relevant values of the row are equal to the previous one
			if($previous_value == $extracted){
				$local_array[]	= $row;
			}
			//if the current value is different from the previous one, we need to check
			//if it corresponds to a previous value
			else{
				//First, we save the current array, because the element extracted is different, so this
				//will create a new current_array. We need to save the current one.
					
					$return_array[$previous_value] = $local_array;
					
			//if the current value has previously been treated, we retrieve the corresponding sub-array
				if(in_array($extracted, $return_array)){
					//Third, we retrieve the sub-array corresponding to $extracted
					$local_array 	= $return_array[$extracted];
					//Forth, we add the current row to the current array
					$local_array[]	= $row;
				}
				//if the current value is not yet in the return_array
				else{
					//reinitialize the array
					$local_array = array($row);
				}
				//The current value and the extracted value are different, so the extracted value becomes the 'current value'
				$previous_value = $extracted;
				
			}
		}
		//after the loop, we need to save the last element
		$return_array[$extracted] = $local_array;
				
		return $return_array;
	}



	//Generate html form elements
	public function generate_form_element($config,$eltType){
		if($config == null){
			return null;
		}
		//http://stackoverflow.com/questions/1680721/how-to-load-helper-from-model-in-codeigniter
		$ci = get_instance();
		$ci->load->helper('form');
		
		$element = '';
		
		switch($eltType){
			case self::CHECKBOX :
				$element = form_checkbox($config);
				break;
			
			case self::DROPDOWN :
				$element = form_dropdown($config);
				break;
				
			case self::RADIO :
				$element = form_radio($config);
				break;
				
			case self::TEXTFIELD :
				$element = form_input($config);
				break;
			
			case self::TEXTAREA :
				$element = form_textarea($config);
				break;
			
			case self::BUTTON :
				$element = form_button($config);
				break;
				
			case self::LABEL :
				$element	= form_label($config['content'],$config['for']);
				break;
			
			case self::MULTILIST :
				//$element 	= form_multiselect($config['name'],array(),'',"id='".$config['id']."'");
				$element = $this->generate_html_tag('select',$config);
				break;
				
			default: 
				$element = '<label>Error: Unknown form element type specified :'.$eltType.'</label>';
			break;
		}
		return $element;
	}

	private function generate_html_tag($tag,$parameters){
		
		$options = '';
		foreach($parameters as $name => $value){
			$options .= "$name='$value' ";
		}
		return "<$tag $options></$tag>";
	}
	
	//Take an array of form elements and generate a form row (bootstrap)
	public function bootstrap_form_row($form_elements,$rowClass = 'row'){
		$elements = '';

		foreach($form_elements as $row){
		
			//If that specific index for detailed row elements is set, we have the normal situation
			if(is_array($row)){
				$form_elt 	= $row[self::FORM_ELEMENT];
				$elt_width	= $row[self::ROW_WIDTH];
			
				$elements	.= "<div class='col-md-$elt_width'>$form_elt</div>";
				
				
			}
			//If the expected index is not set, we have regular elements and we don't specify a width
			else{
				$elements	.= $row;
			}
		}
			
		return "<div class='$rowClass'>$elements</div>";
	}
	
	public function add_form_element_to_row(&$row,$formElement,$widthNumber){
		$row[]	= array(self::FORM_ELEMENT => $formElement, self::ROW_WIDTH => $widthNumber);
	}
	
	public function generate_form($formElements,$action ='',$method='post'){
		$form = '';
		
		foreach ($formElements as $elt) {
			$form .= $elt;
		}
		
		return "<form action='$action' method='$method'>$form</form>";
	}
	
	//Take some information about the form element that we want to generate, and
	//returns a "configuration array" that will be used in "get_form_configuration"
	public function form_element_configuration($elementType,$data,$label = null,$column_name){
		$element = array();
		//Set the type of form element (checkbox, dropdown list, textarea, etc)
		$element[self::FORM_ELEMENT_TYPE] 	= $elementType;
		$element[self::LABEL]				= $label;		//set a label to go with the form element
		$element[self::FORM_DATA]			= $data;		//The initialization data of the html form element
		$element[self::COLUMN_NAME]			= $column_name; //The name to give to the column where this element will be added, in the table
		
		return $element;
	}
	

	public function get_form_configuration($parameters){
		
	}

	//Take an array, or array of objects, and returns an array, or array of arrays.	
	public function to_array($data){
		$array = json_decode(json_encode($data), true);
		return $array;
	}
	/**********************************************************************
	 * 
	 *                        PRIVATE FUNCTIONS
	 *
	 **********************************************************************/
	//generate the '<thead>' tag, which is the head of the table
	private function generate_table_head($rows,$toIgnore,$classes,$formData = null){
		//if the row is empty, we return directly
		if(count($rows) == 0){
			return "<p>Empty array table head.</p>";
		}
		$tclass= isset($classes[self::THCLASS])? $classes[self::THCLASS]: '';

		return '<thead class="'.$tclass.'">'.$this->generate_row($rows,$toIgnore,null,$formData,self::THEAD).'</thead>';
	}
	
	
	//generates the '<tbody>' tab, which is the body of the table
	private function generate_table_body($rows,$toIgnore,$links,$classes = array(),$formData = null){
		//if the row is empty, we return directly
		if(count($rows) == 0){
			return "<p>Empty array table element.</p>";
		}
		
		$result	= '';
		$tclass= isset($classes[self::TBCLASS])? $classes[self::TBCLASS]: '';

		$length = count($rows);
		//we iterate on each row
		for($i = 0; $i<$length;$i++){
			$elt 	= $rows[$i];
			$link	= $links[$i];
			//we obtain the html version of the current row
			$result	.= $this->generate_row($elt,$toIgnore,$link,$formData,self::TBODY);
		}
		
		return '<tbody class="'.$tclass.'">'.$result.'</tbody>';
	}
	
	//generate a single table row (for <tr> and <th> tags)
	private function generate_row($row,$toIgnore,$links,$formConfig = null,$table_part = self::TBODY,$rowClass = ''){
		$rowIndex = 1;
		$html_row 	= '';
		$length 	= count($row);
		
		$keys	= array_keys($row);
	
		// [id] => 1 [First Name] => Alice [Last Name] => Fox [Job] => Entrepreneur
		//we need to generate an html table raw
		foreach($row as $key => $value){
			$ignore_field = $this->toIgnore($toIgnore,$rowIndex);
			
			//if this field must be taken into account
			if(!$ignore_field){
				//echo "Is not set, index: ".strval($rowIndex).'<br/>';
				if($table_part == self::THEAD){
					$html_row .= '<th>'.$key.'</th>';
				}
				//if it is a part of the body, we need to test for links
				else{
					if($links != null and isset($links[strval($rowIndex)])){
						$html_row .= '<td><a href="'.$links[strval($rowIndex)].'">'.$value.'</a></td>';
					}
					else{
						$html_row .= '<td>'.$value.'</td>';
					}
				}
				
			}
			else{
				//echo "Is set, index: ".strval($rowIndex).'<br/>';
			}
			$rowIndex++;
		}//end of for loop
		
		//At the end of this loop, we can check if we need to add some form elemnents
	 	if($formConfig != null){
	 		foreach($formConfig as $formElements){
				$html_row .= $this->generate_form_table_cell($row,$formElements,$table_part);
	 		}
		}

		return '<tr class="'.$rowClass.'">'.$html_row.'</tr>';
	}//end of generate_row

	//generate a <td> or <th> cell, with a html form element inside
	private function generate_form_table_cell($row,$config,$tablePart){
		$elt ='';
		
		if($tablePart == self::THEAD){
			if(isset($config[self::COLUMN_NAME])){
				$elt = $config[self::COLUMN_NAME];
			}
			return '<th>'.$elt.'</th>';
		}
		else if($tablePart == self::TBODY){
			$elt_config = $this->get_element_configuration($row,$config[self::FORM_DATA]);
			$elt 		= $this->generate_form_element($elt_config,$config[self::FORM_ELEMENT_TYPE]);
			return '<td>'.$elt.'</td>';
		}
		else{
			return '<td info="[View_generator]generate_form_table_cell : unknown element type '.$cellType.'">Error</td>';
		}
	}
	
	//Take the row config provided by the user, and return a proper config arra
	private function get_element_configuration($row,$rawConfig,$prefixe = '',$postfixe = ''){
		$finalConfig = array();
		
		if($rawConfig == null or count($rawConfig) == 0){
			return $finalConfig;	
		}
			
		//we loop on each configuration parameter and process those which have an array as value
		foreach($rawConfig as $key => $value){
			if(is_string($value)){
				$finalConfig[$key] = $value;
			}
			else if(is_array($value)){
				$finalConfig[$key] = $prefixe.implode($this->extract_relevant_fields($row, $value)).$postfixe;
			}
			//Unexpected value here
			else{
				log_message('Error','[view_generator]get_element_configuration: Unexpected type of parameter.');
			}
		}
		
		return $finalConfig;
	}

	//we take an array of the fields to ignore, as well as the index of a field.
	//We need to identify if the field should be ignored (i.e. present in the array)
	private function toIgnore($fields_to_ignore,$field_index){
		$exit 	= false;
		$i		= 0;
		$length	= count($fields_to_ignore);
		$keys	= array_keys($fields_to_ignore);

//we loop on the array
		while(!$exit && $i<$length){
			if(strval($fields_to_ignore[$keys[$i]]) == strval($field_index)){
				$exit = true;
			}
			$i++;
			
		}
		
		return $exit;
	}
	
	//generate the link for a single field, of a single row, based on the array $fieldNumbers
	//which describes the fields that must be concatenated.
	private function generate_single_link($row,$fieldNumbers,$type){
		if($fieldNumbers == null or count($fieldNumbers) == 0){
			return null;
		}
	
		$content = '/'.implode($this->extract_relevant_fields($row, $fieldNumbers[self::FIELDS]),'/');
		return $fieldNumbers[self::PREFIX].$content;
	}

	//This function take an array of elements and an array of number. It returns a sub-array
	//containing the elements from the array of elements which where at one of the indexes described
	//in the array of number. Ex : ['a','b','c','d'] and [2,3] will return ['b','c'] (items at the second
	//and third place, when counting normaly (not starting at 0)).
	private function extract_relevant_fields($row,$fieldNumbers){
		$result = array();
		$length	= count($row);
		$fieldIndex = 1;

		//iterate over every field of the row and select the fields which can be found
		//in the array fieldNumbers.
		foreach($row as $key => $field){
			$found = in_array($fieldIndex,$fieldNumbers);
			
			//if the field must be selected
			if($found){
				//We are dealing with links, so we need to turn whitespaces into underscores
				array_push($result,str_replace(' ','_',$field));
			}	
			
			$fieldIndex++;
		}
		
		return $result;
	}
		
}

/* End of files View_generators.php */