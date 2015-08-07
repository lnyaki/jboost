<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class View_generator{
	const THEAD 		= 'thead';			//table head
	const TBODY 		= 'tbody';			//table body
	const THCLASS		= 'thead_class';	//css class for the table head
	const TBCLASS		= 'tbody_class';	//css class for the table body
	const TABLECLASS	= 'table_class';	//css class for the table tag
	const CONCATENATION	= 'concatenation';	//specify that we want to concatenate fields to create link urls
	const FIELDS		= 'fields';			//The constant 'fields' that will be used in the links array
	const PREFIX		= 'prefix';			//The constant 'prefix' that will be used in the links array

	public function generate_array($rows,$toIgnore = array(),$links,$classes = array()){
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
	
	//initializes an array that describes the field link that must be generated
	public function create_row_link($array,$fieldNumber,$fieldsToUse,$prefix = ''){
		$array[strval($fieldNumber)] = array('fields' =>$fieldsToUse, 'prefix' => $prefix);
		
		return $array;
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
	public function to_Array($data){
		$corrected_array = array();
		//test if object
		if(is_object($data)){
			$corrected_array = (array)$data;
		}
		else if(is_array($data)){
			foreach($data as $row){
				if(is_object($row)){
					$corrected_array[] = (array)$row;
				}
				else{
					$corrected_array[] = $row;
				}
			}
		}
		else{
			$corrected_array[] = $data;
		}
		return $corrected_array;
	}
	
	public function to_array2($data){
		$array = json_decode(json_encode($data), true);
		return $array;
	}
	
	
}

/* End of files View_generators.php */