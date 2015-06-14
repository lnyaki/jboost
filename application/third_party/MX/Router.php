<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX core module class */
require dirname(__FILE__).'/Modules.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library extends the CodeIgniter router class.
 *
 * Install this file as application/third_party/MX/Router.php
 *
 * @copyright	Copyright (c) 2011 Wiredesignz
 * @version 	5.4
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Router extends CI_Router
{
	protected $module;
	
	public function fetch_module() {
		return $this->module;
	}
	
	public function _validate_request($segments) {
		log_message('debug','[Core/router.php]validate_request : '.implode('/',$segments));
		
		if (count($segments) == 0) return $segments;
		
		/* locate module controller */
		if ($located = $this->locate($segments)) return $located;
		
		log_message('debug','[Core/router.php]Validate_quest : Could not locate '.implode('/',$segments));
		
		/* use a default 404_override controller */
		if (isset($this->routes['404_override']) AND $this->routes['404_override']) {
			$segments = explode('/', $this->routes['404_override']);
			if ($located = $this->locate($segments)) return $located;
		}
		
		/* no controller found */
		show_404(implode('/', $segments));
	}
	
	/** Locate the controller **/
	public function locate($segments) {		
		
		$this->module = '';
		$this->directory = '';
		$ext = $this->config->item('controller_suffix').EXT;
	
		log_message('debug','01[MX/router.php]Locate : Module: '.$segments[0]);	
		/* use module route if available */
		if (isset($segments[0]) AND $routes = Modules::parse_routes($segments[0], implode('/', $segments))) {
			$segments = $routes;
			
/*Debug update >>*/
			if(count($segments)==0){
				log_message('debug','02[MX/router.php]Locate : Couldn\' find the route.');
			}
/* << Debug update*/
		}
	
		/* get the segments array elements */
		list($module, $directory, $controller) = array_pad($segments, 3, NULL);

		/* check modules */
		foreach (Modules::$locations as $location => $offset) {
		
			/* module exists? */
			if (is_dir($source = $location.$module.'/controllers/')) {
/*>> Debug update >>*/
				log_message('debug','03[MX/router.php]Locate : IS a DIRECTORY : '.$location.$module.'/controllers/');
/*<< Debug update <<*/
				$this->module = $module;
				$this->directory = $offset.$module.'/controllers/';
				
/*>> Debug update >>*/
				log_message('debug','04[MX/router.php]Locate : [Module]'.$this->module.' [Directory]'.$directory.' [source]'.$source);
/*<< Debug update <<*/
				
				/* module sub-controller exists? */
				if($directory AND is_file($source.$directory.$ext)) {
/*>> Debug update >>*/
					log_message('debug','05[MX/router.php]Locate : Sub controller : '.$source.$directory.$ext);
/*<< Debug update <<*/
					return array_slice($segments, 1);
				}
					
				/* module sub-directory exists? */
				if($directory AND is_dir($source.$directory.'/')) {
/*>> Debug update >>*/
					log_message('debug','06[MX/router.php]Locate : Sub directory : '.$source.$directory.'/');
/*<< Debug update <<*/
					$source = $source.$directory.'/'; 
					$this->directory .= $directory.'/';

					/* module sub-directory controller exists? */
					if(is_file($source.$directory.$ext)) {
						return array_slice($segments, 1);
					}
				
					/* module sub-directory sub-controller exists? */
					if($controller AND is_file($source.$controller.$ext))	{
						return array_slice($segments, 2);
					}
				}
/*>> Debug update >>*/
				else{
					log_message('debug','07[MX/router.php]Locate : NO Sub directory : '.$source.$directory.'/');
					if($directory){
						log_message('debug','07[MX/router.php]Locate : However directory : '.$directory);	
					}
					else{
						log_message('debug','07[MX/router.php]Locate : NO  directory : '.$directory);
					}
				}
/*<< Debug update <<*/
				
				/* module controller exists? */			
				if(is_file($source.$module.$ext)) {
/*>> Debug update >>*/
					log_message('debug','08[MX/router.php]Locate : File exists : '.$source.$module.$ext);
/*<< Debug update <<*/
					return $segments;
				}
/*>> Debug update >>*/
				else{
					log_message('debug','09[MX/router.php]Locate : File NOT exists : '.$source.$module.$ext);
				}
/*<< Debug update <<*/
			}
/*>> Debug update >>*/
			else{
				log_message('debug','10[MX/router.php]Locate : NOT a DIRECTORY : '.$location.$module.'/controllers/');
			}
/*<< Debug update <<*/
		}
		
		/* application controller exists? */			
		if (is_file(APPPATH.'controllers/'.$module.$ext)) {
			return $segments;
		}
/*>> Debug update >>*/
			else{
				log_message('debug','11[MX/router.php]Locate : NOT a controller : '.APPPATH.'controllers/'.$module.$ext);
			}
/*<< Debug update <<*/
		
		/* application sub-directory controller exists? */
		if($directory AND is_file(APPPATH.'controllers/'.$module.'/'.$directory.$ext)) {
			$this->directory = $module.'/';
			return array_slice($segments, 1);
		}
		
		/* application sub-directory default controller exists? */
		if (is_file(APPPATH.'controllers/'.$module.'/'.$this->default_controller.$ext)) {
			$this->directory = $module.'/';
			return array($this->default_controller);
		}
	}

	public function set_class($class) {
		$this->class = $class.$this->config->item('controller_suffix');
	}
}