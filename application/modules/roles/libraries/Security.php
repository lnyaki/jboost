<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Security{
//***************************************
//           Security/Privileges
//***************************************
	private $page_privileges	= null;
	private $view_privileges	= null;
	private $ci					= null;

//***************************************
//           Constants
//***************************************	
	const PAGE			= 'page';
	const VIEW			= 'view';
	const PRIVILEGES	= 'privileges';
	
	function __construct(){
		$this->ci = &get_instance();
	}
	/**********************************************************
	 * 			SECURITY and PRIVILEGES -- START
	 * 
	 *********************************************************/
	 //This function loads the user privileges from db and processes them so that they
	 //can be correctly accessed later on.
	 public function load_user_privileges($userID){
	 	//load the sessions library, to save the user privileges
	 	$this->ci->load->library('session');
		//load the 'roles' model to fetch the user privileges
		$this->ci->load->model('roles/roles_model','role');
		
		//using codeigniter session for security reasons
		$raw_privileges		= $this->ci->role->get_user_privileges($userID);
		echo "<br/>";echo "<br/>";
		print_r($raw_privileges);echo "<br/>";echo "<br/>";
		//make sure that the content is an array
		$raw_privileges		= json_decode(json_encode($raw_privileges), true);
		
		//Format the raw privilege array received from db.
		$user_privileges 	= $this->format_privileges_array($raw_privileges);
		echo "PRIVILEGES : ";echo "<br/>";
		print_r($user_privileges);
		
		//Set the privilege array in the user sessions
	 	$this->ci->session->set_userdata(self::PRIVILEGES,$user_privileges);
	 	
	 }
	 
	 //We receive the privilege array from db, and format it into a 2-dimension array.
	 //The first dimension is the module, and second dimension is the privilege.
	 private function format_privileges_array($raw_privileges){
	 	//Make sure that everyting is an array in $raw_privileges
	 	$raw_privileges = $this->ci->view_generator->to_array($raw_privileges);
		//Use get_sub_array to group the array based on the module
		$raw_privileges	= $this->ci->view_generator->get_sub_arrays($raw_privileges,array(1));
		$formatted_array = array();
		
		foreach($raw_privileges as $module => $array){
			$formatted_array[$module]	= array();
			
			//loop on the privileges of this module
			foreach($array as $key => $privilege){
				array_push($formatted_array[$module],$privilege[Roles_model::privilege]);
			}
		}

		return $formatted_array;
	 }
	 
	 
	 //This function returns true if the user in the session has the privilege passed
	 //as parameter. Returns false otherwise.
	 public function has_privilege($module,$privilege){
	 	$response = false;
		
		//get privilege array
		$user_privileges = $this->ci->session->userdata(self::PRIVILEGES);
		
		if($user_privileges){
			if(isset($user_privileges[$module][$privilege])){
				$reponse = true;
			}
		}
		return $response;
	 }
	 
	 //Add a restriction on a page (user which don't have the corresponding module won't be
	 //able to view the content of the page)
	 public function set_page_restriction($module,$privilege){
	 	$this->set_access_restriction($module, $privilege,self::PAGE);
	 }
	 
	 //Add a restriction on a view.
	 public function set_view_restriction($module,$privilege){
	 	$this->set_access_restriction($module,$privilege,self::VIEW);
	 }
	 
	 
	 //This function specifies that a page, or view, is only
	 //accessible to the person who has the corresponding privilege
	 private function set_access_restriction($module,$privilege,$context = self::PAGE){
	 	$tab = null;
				
		if($context == self::PAGE){
			$tab = &$this->page_privileges;
		}
		else if($context == self::VIEW){
			$tab = &$this->view_privileges;
		}
		else{
		//if the context is unknown, we log it, then proceed as if the context was self::PAGE.
			$tab = &$this->page_privileges;
			log_message('error','Unknown access context : '.$context);
		}
		
	 	//initialize array if array is null
	 	if($tab == null){
	 		$tab = array();	
	 	}
		
		//check if an entry on this module already exist
		if(isset($tab[$module])){
			$tab[$module][] = $privilege;
		}
		//if there no entry for this module yet, we create one
		else{
			$tab[$module] = array($privilege);
		}
	 }
	 
	 public function has_access_to_page(){
	 	return $this->has_access(self::PAGE);
	 }
	 
	 public function has_access_to_view(){
	 	return $this->has_access(self::VIEW);
	 }
	 //This function checks if the user has the right to all the privileges specified
	 //by function set_access_restriction.
	 private function has_access($context){
	 	$this->ci->load->library('session');

	 	$contextPrivileges;

	 	if($context === self::PAGE){
	 		$contextPrivileges = &$this->page_privileges;
	 	}
		else if($context === self::VIEW){
			$contextPrivileges = &$this->view_privileges;
		}
		else{
			$contextPrivileges = &$this->page_privileges;
			log_message('error','Unkown access context : '.$context);
		}
		
		$userPrivileges 	= $this->ci->session->userdata(self::PRIVILEGES);
		
		return $this->has_all_Access($userPrivileges,$contextPrivileges);
	 }
	 
	 private function has_all_access($userPrivileges,$contextPrivileges){
	 	//If there is no access restriction
	 	if($contextPrivileges == null or count($contextPrivileges) == 0){
	 		return true;
	 	}
		//If there are restrictions
		else{
			//If the user has no privilege
			if($userPrivileges == null or count($userPrivileges) == 0){
				return false;
			}

			//If both arrays contain privileges
			$exit = false;
			$context_length	= count($contextPrivileges);
			
			$contextKeys 	= array_keys($contextPrivileges);
			$i = 0;
			
			//We test if each context privilege exist in the $user privileges
			while(!$exit and $i<$context_length){
				//get the contex key
				$key = $contextKeys[$i];
				
				//If the user has the same module as the context, we check the privilege
				if(isset($userPrivileges[$key])){
					$sortie = false;
					$modulePrivileges 	=  $contextPrivileges[$key];
					$privilegeCount	= count($modulePrivileges);
					$j = 0;
					//Now we loop on each privilege of this module
					while(!$sortie and $j<$privilegeCount){
						$localPrivilege = $modulePrivileges[$j];
						
						//Does the user have the same privilege?
						//if(!isset($userPrivileges[$key][$localPrivilege])){
						if(!in_array($localPrivilege, $userPrivileges[$key])){
							$sortie = true;
						}
						$j++;
					}
					//At the end of this loop, we set $exit to the value of $sortie. If $sorte is true,
					//this means that the user is missing some privilege. 
					$exit = $sortie;
				}
				//If the user doesn't have rights on the module, we stop direct.
				else{
					$exit = true;
				}
				$i++;
			}
			return !$exit;
		}
	 }

	public function is_logged_in(){
	 	$this->ci->load->library('session');
		
		if(!$this->ci->session->userdata(self::PRIVILEGES)){
			return false;
		}
		else{
			return true;
		}	
	 }
	 
	 
	/**********************************************************
	 * 		[END] -- SECURITY and PRIVILEGES -- [END]
	 * 
	 *********************************************************/ 
	
}