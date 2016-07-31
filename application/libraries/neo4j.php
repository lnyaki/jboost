<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
require_once 'vendor/autoload.php';
use GraphAware\Neo4j\Client\ClientBuilder;

class Neo4j {
	private $neo4j;
	
	//connect to the neo4j database
    public function connect(){
    	//load CI to access config files 
    	$CI = & get_instance();

    	//Get database details from the config file
    	$user 		= $CI->config->item('username');
		$password	= $CI->config->item('password');
		$host		= $CI->config->item('hostname');
		$port		= $CI->config->item('port');
		//$database	= $CI->config->item('database');
		
		
		//build connect to db
		$client = ClientBuilder::create()
    			->addConnection('default', 'http://'.$user.':'.$password.'@'.$host.':'.$port)
    			->build();
    	
		//save the connection object in a private class variable
		$this->neo4j	= $client;
	}
	
	//Returns the connection object to the neo4j database
	public function get_db(){
		return $this->neo4j;
	}
}

/* End of file Someclass.php */