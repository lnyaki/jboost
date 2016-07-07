<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'vendor/autoload.php';
use GraphAware\Neo4j\Client\ClientBuilder;

class Neo4j_controller extends TNK_Controller{
	
	//connect to neo4j db on instantiation
	function __construct(){
		parent::__construct();
		
		$this->load->library('neo4j');
		
		$this->neo4j->connect();
	}
}