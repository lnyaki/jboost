<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

if ( ! function_exists('call_mode')){
    function call_mode($fields){
    	return implode(', ',$fields);
    }
}

if(!function_exists('sha1_salt')){
	function sha1_salt($content){
		$salt 		= '';
		$first_char = '';
		$last_char 	= '';
		$length 	= strlen($content);
		
		if($length > 0){
			$first_char	= strtoupper(substr($content,0,1));
			$last_char	= strtoupper(substr($content,strlen($content)-1,1));
			$salt = '!XoR1P91*#'.$first_char.$last_char;
		}
		
			
		return sha1($salt.$content);
	}
}
/* End of file Someclass.php */