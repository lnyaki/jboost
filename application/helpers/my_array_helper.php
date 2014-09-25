<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

if ( ! function_exists('html_table')){
//returns an html table based on the html from the header and body
    function html_table($header,$body,$tableClass = ''){
    	$table = "<table class='".$tableClass."'>";
    	$table	.= $header;
		$table	.= $body;
		$table	.= "</table>";
    	return $table;
    }
}

if ( ! function_exists('html_table_head')){
//create a html table header row, based on a list of fields
    function html_table_head($fields,$headClass = '',$th_class = ''){
    	$table = "<thead class='".$headClass."'>";
    	$table	.= "<tr>";
		
		foreach($fields as $field){
			$table	.= "<th class='".$th_class."'>".$field."</th>";
		}
		
		$table 	.= "</tr>";
		$table	.= "</thead>";
		
    	return $table;
    }
}


if ( ! function_exists('html_table_body')){
//create a html table header row, based on a list of fields
    function html_table_body($rows,$bodyClass = '',$td_class = '',$link = array()){
    	$table = "<tbody class='".$bodyClass."'>";
		$hasLink = false;
		
		if(count($link) == 2){
			$pageLink 		= $link[0];
			$columnIndex	= $link[1];
			$hasLink		= true;
		}
		else{
			$hasLink		= false;
		}
		
		foreach($rows as $row){
			$count 		= 1;
			$html_row 	= '<tr>';
			
			foreach($row as $elt){
				if($hasLink and $columnIndex == $count){
					$html_row .= "<td class='".$td_class."'><a href='".$pageLink."$elt"."'>".$elt."</a></td>";
				}
				else{
					$html_row .= "<td class='".$td_class."'>".$elt."</td>";	
				}
				$count++;
				
			}
			$html_row 	.= '</tr>';
			
			$table 		.= $html_row;
		}
		
		$table	.= "</tbody>";
		
    	return $table;
    }
}