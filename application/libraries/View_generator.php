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
	public function generate_titled_array($titles,$rows,$toIgnore,$links,$classes = array()){
		$final_content = '';
		//initialize toIgnore, if null
		$toIgnore = ($toIgnore == null)? array(): $toIgnore;
		
		//Create the title prefix and title postfix variables
		$prefix 	= $titles[self::PREFIX];
		$postfix	= $titles[self::POSTFIX];
		
		if($titles == null){
			$final_content = $this->generate_array($rows,$toIgnore,$links,$classes);
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

			$final_content .= $this->generate_array($rows,$toIgnore,$links,$classes);
		}
		
		return $final_content;
	} 
	public function generate_array($rows,$toIgnore = array(),$links,$classes = array()){
		//Make sure that the $rows are on array form
		$rows = $this->to_array($rows);
		//Transform the raw link data into real links
		$links = $this->generate_links($rows, $links);	
		$i 		= 0;
		
		if($toIgnore == null){
			$toIgnore = array();
		}
		//Make sur that the $rows array contains other arrays, and not objects
		$rows = $this->to_Array($rows);
		
		//if the data provided is an empty array, we return
		if(count($rows) == 0){
			return '<p>No data available</p>';
		}
		
		//get the head of the table
		$table_head = $this->generate_table_head($rows[0],$toIgnore,$classes);
		
		//get the body of the table
		$table_body	= $this->generate_table_body($rows,$toIgnore,$links,$classes);
		
		$result		= '<table class="table">'.$table_head.$table_body.'</table>';
	
		return $result;
	}
	
	public function initialize_array_title($title,$title_row,$prefix ='',$postfix = ''){
		$title_array = array();
				
		$prefix = ($prefix == null)?'': $prefix;
		$postfix= ($postfix == null)?'':$postfix;
		
		$title_array[self::ARRAY_TITLE] 	= $title;
		$title_array[self::ARRAY_TITLE_ROW]	= $title_row;
		$title_array[self::PREFIX]			= $prefix;
		$title_array[self::POSTFIX]			= $postfix;
		return $title_array;
	}
	
	//initializes an array that describes the field link that must be generated
	public function create_row_link($array,$fieldNumber,$fieldsToUse,$prefix = ''){
		if($array == null){
			$array = array();
		}
		$array[strval($fieldNumber)] = array('fields' =>$fieldsToUse, 'prefix' => $prefix);
		
		return $array;
	}
	
	//generate links (for tag <a>) based on an array of data.
	public function generate_links($data,$fieldNumbers,$type = self::CONCATENATION){
			
		$links_array = array();

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
		
	}
	/**********************************************************************
	 * 
	 *                        PRIVATE FUNCTIONS
	 *
	 **********************************************************************/
	//generate the '<thead>' tag, which is the head of the table
	private function generate_table_head($rows,$toIgnore,$classes){
		//if the row is empty, we return directly
		if(count($rows) == 0){
			return "<p>Empty array table head.</p>";
		}
		$tclass= isset($classes[self::THCLASS])? $classes[self::THCLASS]: '';

		return '<thead class="'.$tclass.'">'.$this->generate_row($rows,$toIgnore,null,self::THEAD).'</thead>';
	}
	
	
	//generates the '<tbody>' tab, which is the body of the table
	private function generate_table_body($rows,$toIgnore,$links,$classes = array()){
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
			$result	.= $this->generate_row($elt,$toIgnore,$link,self::TBODY);
		}
		
		return '<tbody class="'.$tclass.'">'.$result.'</tbody>';
	}
	
	//generate a single table row (for <tr> and <th> tags)
	private function generate_row($row,$toIgnore,$links,$table_part,$rowClass = ''){
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
		
		return '<tr class="'.$rowClass.'">'.$html_row.'</tr>';
	}//end of generate_row

	
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
				array_push($result,$field);
			}	
			
			$fieldIndex++;
		}
		
		return $result;
	}
	
	//Take an array, or array of objects, and returns an array, or array of arrays.	
	public function to_array($data){
		$array = json_decode(json_encode($data), true);
		return $array;
	}
	
	
}

/* End of files View_generators.php */