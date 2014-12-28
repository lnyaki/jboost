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
