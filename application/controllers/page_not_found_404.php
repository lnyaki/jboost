<?php

class Page_not_found_404 extends TNK_Controller {
	
	public function index(){
		$this->title("Page not found");
		
		//get view
		$view = '<p>Page not found</>';
		
		$this->add_block($view,self::CENTER_BLOCK);
		$this->generate_page();
	}
	
}