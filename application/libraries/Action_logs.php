<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Action_logs{
	//-------------------------------//
	//     Array index constants     //
	//-------------------------------//
	//Creation
	const CREATION_DATE 		= 'creation_date';
	const CREATION_TIME			= 'creation_time';
	const CREATION_USER			= 'creation_user';
	//Modification
	const MODIFICATION_DATE		= 'modification_date';
	const MODIFICATION_TIME		= 'modification_time';
	const MODIFICATION_USER 	= 'modification_user';
	//Action
	const ACTION_TYPE			= 'action_type';
	const ACTION_CREATION		= 'action_creation';
	const ACTION_MODIFICATION	= 'action_modification';
	const ACTION_DELETION		= 'action_deletion';
	
	//This function create an array with informations about date,time and the current user
	public function get_action_log($user,$action = ''){
		$log	= array();
		
		$log[self::MODIFICATION_DATE]	= '';
		$log[self::MODIFICATION_TIME]	= '';
		$log[self::MODIFICATION_USER]	= $user;
		$log[self::ACTION_TYPE]			= $action;
		
		return $log;
	}
	
	//This function returns an array with a creation date, a creation time, and the user who created.
	public function get_creation_time_data($user){
		$log	= array();
		
		$log[self::CREATION_DATE]	= '';
		$log[self::CREATION_TIME]	= '';
		$log[self::CREATION_USER]	= $user;
		
		return $log;
	}
	
	//This function will insert 7 fields to the table passed in arguments.
	//Use Forge (a thing for db modification in CI)
	public function enable_logs_in_table($tablename){
		
	}
}
/* End of files Action_logs.php */