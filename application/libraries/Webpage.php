<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Webpage {
//***************************************
//           Page
//***************************************
	private $title			= null;
	private $page_header	= ''; //header for the webpage
	private $left			= '';
	private $right			= '';
	private $center			= '';
	private $footer 		= '';
	
	private $html_header	= null; //technical, html header
		
//***************************************
//           Scripts
//***************************************
	private $default_css 	= null;
	private $default_js		= null;
	private $css			= null;
	private $js				= null;
	private $script			= null;

	
	
	//Append an html block to a part of the page.
	public function add_block($block, $side ="center"){
		
		switch($side){
			case "header" :
				$page_header	.= $block;
				break;
			case "left"	:
				$left			.= $block;
				break;
			case "right" :
				$right 			.= $block;
				break;
			case "center" :
				$center 		.= $block;
				break;
			case "footer" :
				break;
			default : 
				add_bloc("center");
		}
	}
	
//Generate the final HTML code  of the page
	public function generate_page(){
	//add the css files used by this page to a css object
		add_default_css();
		
	//add the js files used by this page to a js object
		add_default_js();
		
	//generate the html header code for the import of js files
		$this->html_header  = $this->import_js2($this->default_js);
		$this->html_header .= $this->import_js2($this->js);
		
	//generate the page header
		$this->page_header = $this->load->view('templates/header',null,TRUE);//shouldn't this be at higher level?
	
	}
	

	
    public function create_page($data2){
		$scripts['_js']		= $this->js;
		$scripts['_css']	= $this->css;

		$data['_title']		= $this->title;
		//load html head
		
		/*********************************************************
		 *              add the default css
		 *********************************************************/
		add_default_css();
		
		/*********************************************************
		 *              add the default javascript
		 *********************************************************/
		add_default_js();
		
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
		$this->add_css(base_url().'assets/css/bootstrap-theme.min.css',true);
		$this->add_css(base_url().'assets/css/bootstrap.min.css',true);
		$this->add_css(base_url().'assets/css/style-blue.css',true);
		$this->add_css(base_url().'assets/css/font-awesome.min.css',true);
		$this->add_css(base_url().'assets/css/test.css',true);
	}

//add the default js files of this page
	private function add_default_js(){
		$this->add_js(base_url().'assets/js/jquery-2.0.3.min.js',true);
		$this->add_js(base_url().'assets/js/bootstrap.min.js',true);
	}

	public function title($title){
		$this->title = $title;
	}
}