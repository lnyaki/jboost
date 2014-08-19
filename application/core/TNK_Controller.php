<?php

class TNK_Controller extends CI_Controller{
	private $default_css 	= null;
	private $default_js		= null;
	private $css			= null;
	private $js				= null;
	private $title			= null;
	private $script			= null;
	
	public function __construct(){
		parent::__construct();
	}	
	
	public function create_page($data2){
		$scripts['_js']		= $this->js;
		$scripts['_css']	= $this->css;

		$data['_title']		= $this->title;
		//load html head
		
		/*********************************************************
		 *              add the default css
		 *********************************************************/
		$this->add_css(base_url().'assets/css/bootstrap-theme.min.css',true);
		$this->add_css(base_url().'assets/css/bootstrap.min.css',true);
		$this->add_css(base_url().'assets/css/style-blue.css',true);
		$this->add_css(base_url().'assets/css/font-awesome.min.css',true);
		$this->add_css(base_url().'assets/css/test.css',true);
		
		/*********************************************************
		 *              add the default javascript
		 *********************************************************/
		$this->add_js(base_url().'assets/js/jquery-2.0.3.min.js',true);
		$this->add_js(base_url().'assets/js/bootstrap.min.js',true);
		
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
	
	public function title($title){
		$this->title = $title;
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
	
}
?>
