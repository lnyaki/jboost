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
	const BLANK_PAGE	= 5;	//Page with no header, or footer. Just center content
	
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
				$this->right 		.= $block;
				break;
			case self::CENTER_BLOCK :
				$this->center 		.= $block;
				break;
			case self::FOOTER_BLOCK :
				$this->footer		.= $block;
				break;
			default : 
				$this->add_block($block,self::CENTER_BLOCK);
		}
	}	
	
//Generate the final HTML code  of the page
//This function takes the data added by the controller to this object, and
//uses this data (scripts, views, arrays, strings) to generate the final HTML page.
	public function generate_page($page_style = self::NORMAL_PAGE){
	//get the template of the page (side elements, center only, etc)
		$template_path = $this->get_content_template_path($page_style);
		//$template_path = 'templates/content';
		
	//We load the css, js and script files (initializing $this->html_header (css) and $this->html_scripts (js))
		$this->load_external_files($page_style);

	//We generate all the page content into a final array of data
		$data	= $this->generate_page_elements($page_style);
	
		$page_path = '';
	//We generate the web page to the user.
		switch($page_style){
			case self::BLANK_PAGE:
				$page_path	= 'templates/blank_page';	
				break;
			
			default : 
				$page_path	= 'templates/normal_page';
		}
		$this->load->view($page_path, $data);	
		//$this->load->view('templates/normal_page',$data);
	}
	
	//We load all the required css, js and scripts provided by the user
	private function load_external_files($page_style = self::NORMAL_PAGE){
		//We add the default css and js to pages if they are not of type BLANK_PAGE
		if($page_style !== self::BLANK_PAGE){
			//add the default css files used by this page to a css object
			$this->add_default_css();
		
			//add the default js files used by this page to a js object
			$this->add_default_js();
		}
		
		//We add user specified css (assets), js (assets) and scripts (application/views/scripts)
		
		//generate the html code for the import of css files
		$this->html_header  = $this->import_css2($this->default_css);
		$this->html_header .= $this->import_css2($this->css);
		
		//generate the html code for the import of js files
		$this->html_scripts  = $this->import_js2($this->default_js);
		$this->html_scripts .= $this->import_js2($this->js);
		
		//import the scripts (local html containing js, defined as views (might need to change that))
		$this->html_scripts .= $this->import_scripts($this->script);
		
	}
	
	//We generate the various subparts of the page (header,footer,content) into an array (data) that we return.
	private function generate_page_elements($page_style = self::NORMAL_PAGE){
		$template_path = '';
		
		//If we are not with a blank page, we generate header and footer (the blank page doesn't need those).
		if($page_style !== self::BLANK_PAGE){
			//generate the page header
			$this->page_header 	= $this->load->view('templates/header',null,TRUE);
	
			//generate the page footer
			$this->footer		= $this->load->view('templates/footer',null,TRUE);
		}
		
		//Set the correct content view based on the page style
		switch($page_style){
			case self::NORMAL_PAGE	:
				$template_path	= 'templates/content_normal';
				break;
			
			case self::BLANK_PAGE	:
				$template_path	= 'templates/content_center_only';
				break;
			
			case self::LEFT_SIDE	:
				$template_path	= 'templates/content_left_center';
				break;
			
			case self::RIGHT_SIDE	:
				$template_path	= 'templates/content_right_center';
				break;
			
			case self::CENTER_ONLY	:
				$template_path	= 'templates/content_center_only';
				break;

			default:
				$template_path	= 'templates/content_normal';
		}
		
		//generate the whole content of the page
		$total_content 		= $this->generate_content($template_path,$this->left,$this->center,$this->right);

		//Create an array with all the data (header, footer,content, etc) required to hydrate the Page view file.
		$data = $this->generate_data_array($this->html_header,
											$this->title,
											$this->page_header,
											$total_content,
											$this->footer,
											$this->html_scripts);

		return $data;
	}
	
	private function generate_data_array($html_header, $title,$header,$content,$footer,$scripts){
		return array('_html_header'	=> $html_header,
					'_title'		=> $title,
					'_site_header' 	=> $header,
					'_content' 		=> $content,
					'_footer' 		=> $footer,
					'_scripts'		=> $scripts);
	}
	
	private function get_content_template_path($page_style){
		$path = '';
		
		switch($page_style){
			case self::NORMAL_PAGE :
				$path	= 'templates/content_normal';
				break;
			
			case self::LEFT_SIDE	:
				$path	= 'templates/content_left_center';
				break;
				
			case self::RIGHT_SIDE	:
				$path	= 'templates/content_right_center';
				break;
			
			case self::CENTER_ONLY	:
				$path	= 'templates/content_center_only';
				break;
			
			default					:
				$path	= 'templates/content_normal';
		}
		
		return $path;
	}
	
	/*
	public function create_page($data2){
		$scripts['_js']		= $this->js;
		$scripts['_css']	= $this->css;

		$data['_title']		= $this->title;
		//load html head
		
		/********************************************************
		 *              add the default css
		/********************************************************* /
		$this->add_default_css();
		
		/*********************************************************
		 *              add the default javascript
		/********************************************************* /
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
*/
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
	
	public function add_module_js($module,$file,$default = false){
		$this->add_js($module.'/assets/js/'.$file,$default);
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
	public function add_script2($module,$file = null,$data = array()){
		$script = '';
		$base = 'scripts/';
		
		//if only the first arg is set, it means that it is a regular call, and we must
		//get the file from app/views/xxx
		if($file == null){
			$script = $this->load->view($base.$module,$data,true);	
		}
		//if the 2 args are set, it means that we need to go check in the module views.
		else{
			$script = $this->load->view($module.'/'.$base.$file,$data,true);	
		}

		$this->add_script($script);
	}
	
	public function title($title){
		$this->title = $title;
	}
	
	
	public function view($path,$data = array(),$generate_html = TRUE){
		return $this->load->view($path,$data,$generate_html);
	}
	
	//generate the main content of the page (without header or footer)
	private function generate_content($path = 'templates/content_normal.php',$left_side = '',$center = '',$right_side = ''){
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
