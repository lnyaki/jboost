<?php

class TNK_Controller extends MX_Controller{
//***************************************
//           Page
//***************************************
	private $title			= null;
	private $page_header	= ''; //header for the webpage
	private $left			= '';
	private $right			= '';
	private $center			= '';
	private $footer 		= '';
	private $html_scripts	= ''; //html code of the scripts
	
	private $html_header	= null; //technical, html header
		
//***************************************
//           Scripts
//***************************************
	private $default_css 	= null;
	private $default_js		= null;
	private $css			= null;
	private $js				= null;
	private $script			= null; //table with the names of scripts
	
//***************************************
//           Security/Privileges
//***************************************
	private $page_privileges	= null;
	private $view_privileges	= null;

//***************************************
//           Constants
//***************************************
//--------- Page types constants -----------
	const NORMAL_PAGE 	= 1; 	// a left side, right side, and center
	const LEFT_SIDE		= 2;	// left side and center
	const RIGHT_SIDE	= 3;  	// right side and center
	const CENTER_ONLY	= 4;	// just one big center
	
//--------- Block types constants -----------
	const HEADER_BLOCK	= 10;
	const LEFT_BLOCK	= 11;
	const RIGHT_BLOCK	= 12;
	const CENTER_BLOCK 	= 13;
	const FOOTER_BLOCK	= 14;

//--------- Security constants --------------
	const PAGE			= 'page';
	const VIEW			= 'view';
	const PRIVILEGES	= 'privileges';
	
	public function __construct(){
		parent::__construct();
	}	
	
	//Append an html block to a part of the page.
	public function add_block($block, $side = self::CENTER_BLOCK){
		
		switch($side){
			case self::HEADER_BLOCK :
				$this->page_header	.= $block;
				break;
			case self::LEFT_BLOCK	:
				$this->left			.= $block;
				break;
			case self::RIGHT_BLOCK :
				$this->right 			.= $block;
				break;
			case self::CENTER_BLOCK :
				$this->center 		.= $block;
				break;
			case self::FOOTER_BLOCK :
				$this->footer			.= $block;
				break;
			default : 
				$this->add_block($block,self::CENTER_BLOCK);
		}
	}
	
//Generate the final HTML code  of the page
//This function takes the data added by the controller to this object, and
//uses this data (scripts, views, arrays, strings) to generate the final HTML page.
	public function generate_page($page_style = ''){
	//get the template of the page (side elements, center only, etc)
		//$template_path = $get_appropriate_template();
		$template_path = 'templates/content';
	//add the css files used by this page to a css object
		$this->add_default_css();
		
	//add the js files used by this page to a js object
		$this->add_default_js();
		
	//generate the html code for the import of css files
		$this->html_header  = $this->import_css2($this->default_css);
		$this->html_header .= $this->import_css2($this->css);
		
		
	//generate the html code for the import of js files
		$this->html_scripts  = $this->import_js2($this->default_js);
		$this->html_scripts .= $this->import_js2($this->js);
		
	//import the scripts (local html containing js, defined as views (might need to change that))
		$this->html_scripts .= $this->import_scripts($this->script);
		
	//generate the page header
		$this->page_header 	= $this->load->view('templates/header',null,TRUE);//shouldn't this be at higher level?
	
	//generate the whole content of the page
		$total_content 		= $this->generate_content($template_path,$this->left,$this->center,$this->right);
	
	//generate the page footer
		$this->footer		= $this->load->view('templates/footer','',TRUE);
	
		//$data['content']		= $this->load->view('templates/content.php',$data2,true);
		$data = $this->generate_data_array($this->html_header,
											$this->title,
											$this->page_header,
											$total_content,
											$this->footer,
											$this->html_scripts);
		$this->load->view('templates/blank_page',$data);
	}
	
	private function generate_data_array($html_header, $title,$header,$content,$footer,$scripts){
		return array('_html_header'	=> $html_header,
					'_title'		=> $title,
					'_site_header' 	=> $header,
					'_content' 		=> $content,
					'_footer' 		=> $footer,
					'_scripts'		=> $scripts);
	}
	/**********************************************************
	 * 			SECURITY and PRIVILEGES -- START
	 * 
	 *********************************************************/
	 //This function loads the user privileges from db and processes them so that they
	 //can be correctly accessed later on.
	 public function load_user_privileges($userID){
	 	//load the sessions library, to save the user privileges
	 	$this->load->library('session');
		//load the 'roles' model to fetch the user privileges
		$this->load->model('roles/roles_model','role');
		
		//using codeigniter session for security reasons
		$raw_privileges		= $this->role->get_user_privileges($userID);
		//make sure that the content is an array
		$raw_privileges		= json_decode(json_encode($raw_privileges), true);
		
		//Format the raw privilege array received from db.
		$user_privileges 	= $this->format_privileges_array($raw_privileges);
		
		//Set the privilege array in the user sessions
	 	$this->session->set_userdata('privileges',$user_privileges);
	 	
	 }
	 
	 //We receive the privilege array from db, and format it into a 2-dimension array.
	 //The first dimension is the module, and second dimension is the privilege.
	 private function format_privileges_array($raw_privileges){
	 	//Make sure that everyting is an array in $raw_privileges
	 	$raw_privileges = $this->view_generator->to_array($raw_privileges);
		//Use get_sub_array to group the array based on the module
		$raw_privileges	= $this->view_generator->get_sub_arrays($raw_privileges,array(1));
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
		$user_privileges = $this->session->userdata(self::PRIVILEGES);
		
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
	 	$this->load->library('session');

	 	$contextPrivileges;

	 	if($context = self::PAGE){
	 		$contextPrivileges = &$this->page_privileges;
	 	}
		else if($context = self::VIEW){
			$contextPrivileges = &$this->view_privileges;
		}
		else{
			$contextPrivileges = &$this->page_privileges;
			log_message('error','Unkown access context : '.$context);
		}
		
		$userPrivileges 	= $this->session->userdata(self::PRIVILEGES);
		
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
	 
	 
	/**********************************************************
	 * 		[END] -- SECURITY and PRIVILEGES -- [END]
	 * 
	 *********************************************************/ 
	
	public function create_page($data2){
		$scripts['_js']		= $this->js;
		$scripts['_css']	= $this->css;

		$data['_title']		= $this->title;
		//load html head
		
		/*********************************************************
		 *              add the default css
		 *********************************************************/
		$this->add_default_css();
		
		/*********************************************************
		 *              add the default javascript
		 *********************************************************/
		$this->add_default_js();
		
		$default = TRUE;
		
		//generate the link tags required for importing css
		$data['_html_header']	 = $this->import_css($default). $this->import_css(!$default);
		
		//load website header
		$data['_site_header']	= $this->load->view('templates/header',$scripts,TRUE);
		
		$data['_content'] 		= $data2['content'];
		
		$data['_scripts']		 = $this->import_js($default). $this->import_js(!$default);
		$data['_scripts']		.= isset($data2['_scripts'])?$data2['_scripts']:'';
		$data['_footer']		= $this->load->view('templates/footer','',TRUE);
		$this->load->view('templates/blank_page',$data);
	}
	
	public function add_css($css, $default = FALSE){
		$css = base_url().$css;
		//if we must add to the default css array
		if($default){
			if($this->default_css!=null){
				$this->default_css[]	= $css;
			}
			else{
				$this->default_css		= array($css);
			}
		}
		//if we must add to the user defined css array
		else{
			if($this->css!=null){
				$this->css[]	= $css;
			}
			else{
				$this->css		= array($css);
			}
		}
		
	}
	
	//$default indicate if the js must be added to the default list of js files
	public function add_js($js,$default = FALSE){
		$js = base_url().$js;
		//if we must add to the default js array
		if($default){
			if($this->default_js!=null){
				$this->default_js[]	= $js;
			}
			else{
				$this->default_js		= array($js);
			}	
		}
		//if we must add to the user defined js array
		else{
			if($this->js!=null){
				$this->js[]	= $js;
			}
			else{
				$this->js		= array($js);
			}	
		}
		
	}
	
	public function add_script($script, $language = 'js'){
		
		if($this->script!=null){
			$this->script[]	= $script;
		}
		else{
			$this->script		= array($script);
		}
	}
	
	//This add_script functions is an improvement over the previous one. You only specify the path
	public function add_script2($module,$file = null){
		$script = '';
		$base = 'scripts/';
		
		//if only the first arg is set, it means that it is a regular call, and we must
		//get the file from app/views/xxx
		if($file == null){
			$script = $this->load->view($base.$module,null,true);	
		}
		//if the 2 args are set, it means that we need to go check in the module views.
		else{
			$script = $this->load->view($module.'/'.$base.$file,null,true);	
		}

		$this->add_script($script);
	}
	
	public function title($title){
		$this->title = $title;
	}
	
	
	public function view($path,$data,$generate_html = TRUE){
		return $this->load->view($path,$data,$generate_html);
	}
	
	//generate the main content of the page (without header or footer)
	private function generate_content($path = 'templates/content.php',$left_side = '',$center = '',$right_side = ''){
		return $this->load->view($path
								,array(	'_left_aside' 	=> $left_side,
										'_content' 		=> $center,
										'_right_aside' 	=> $right_side)
								,true);
	}

	//return link tags for importing css files	
	private function import_css($default = FALSE){
		if($default){
			$tab = $this->default_css;
		}	
		else{
			$tab = $this->css;
		}
			
		$css_content = '';
		if(isset($tab)){
			foreach($tab as $css){
				$css_content .= ' <link rel="stylesheet" href="'.$css.'" />';
			}	
		}
		return $css_content;
	}

	//return script tags for importing javascript files
	private function import_js($default = FALSE){
		if($default){
			$tab = $this->default_js;
		}
		else{
			$tab = $this->js;
		}
		
		$js_content 	= '';
		if(isset($tab)){
			foreach($tab as $js){
				$js_content .= '<script src="'.$js.'"></script>';
			}
		}
		return $js_content;
	}
	
	//return link tags for importing css files	
	private function import_css2($css_files){
		$css_content = '';
		if(isset($css_files)){
			foreach($css_files as $css){
				$css_content .= ' <link rel="stylesheet" href="'.$css.'" />';
			}	
		}
		return $css_content;
	}
	
	//return script tags for importing javascript files
	private function import_js2($js_files){
		$js_content 	= '';
		if(isset($js_files)){
			foreach($js_files as $js){
				$js_content .= '<script src="'.$js.'"></script>';
			}
		}
		return $js_content;
	}
	
	//return the concatenated scripts tags (they are unedited and just put one after another)
	private function import_scripts($script_array){
		$script_response	= '';

		if(isset($script_array)){
			foreach($script_array as $script){
				$script_response .= $script;
			}
		}
		return $script_response;
	}
	
	//add the default css files of this page
	private function add_default_css(){
		$this->add_css('assets/css/bootstrap-theme.min.css',true);
		$this->add_css('assets/css/bootstrap.min.css',true);
		$this->add_css('assets/css/style-blue.css',true);
		$this->add_css('assets/css/font-awesome.min.css',true);
		$this->add_css('assets/css/test.css',true);
	}

//add the default js files of this page
	private function add_default_js(){
		$this->add_js('assets/js/jquery-2.0.3.min.js',true);
		$this->add_js('assets/js/bootstrap.min.js',true);
	
	}
	
}
?>
