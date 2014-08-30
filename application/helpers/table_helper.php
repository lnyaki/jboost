<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

if ( ! function_exists('call_mode')){
    function call_mode($fields){
    	return implode(', ',$fields);
    }
}

/* End of file Someclass.php */