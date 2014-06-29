<?php

class TNK_Loader extends CI_Loader{

	public function __construct(){
		parent::__construct();
	}
	
	public function toto($elt){
		$content = "";
		if (isset(${$elt})){
			echo "$".$elt." is set - 2 <br/>";
		}
		else{
			echo "$".$elt." is not set - 2<br/>";
		}
		echo "salut toto, je suis toto";
	}
}
?>