<?php

class TNK_Controller extends CI_Controller{
	private $css	= null;
	private $js		= null;
	private $title	= null;
	private $script	= null;
	
	public function __construct(){
		parent::__construct();
	}	
	
	public function create_page($data2){
		$scripts['_js']		= $this->js;
		$scripts['_css']	= $this->css;

		$data['_title']		= $this->title;
		//load html head
		
		$data['_html_header']	 = $this->import_css();
		
		//load website header
		$data['_site_header']	= $this->load->view('templates/header',$scripts,TRUE);
		$data['_content'] 		= $data2['content'];
		$data['_scripts']		 = $this->import_js();
		$data['_scripts']		.= isset($data2['_scripts'])?$data2['_scripts']:'';
		$data['_footer']		= $this->load->view('templates/footer','',TRUE);
		$this->load->view('templates/blank_page',$data);
	}
	
	public function add_css($css){
		if($this->css!=null){
			$this->css[]	= $css;
		}
		else{
			$this->css		= array($css);
		}
	}
	
	public function add_js($js){
		if($this->js!=null){
			$this->js[]	= $js;
		}
		else{
			$this->js		= array($js);
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
	private function import_css(){
		$css_content = '';
		if(isset($this->css)){
			$max	= count($this->css);
			foreach($this->css as $css){
				$css_content .= ' <link rel="stylesheet" href="'.$css.'" />';
			}	
		}
		return $css_content;
	}

	//return script tags for importing javascript files
	private function import_js(){
		$js_content 	= '';
		if(isset($this->js)){
			$max	= count($this->js);
			foreach($this->js as $js){
				$js_content .= '<script src="'.$js.'"></script>';
			}
		}
		return $js_content;
	}
	
}
?>
