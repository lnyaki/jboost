<?php
require_once(APPPATH . '/modules/test/controllers/Toast.php');

class JapaneseTest extends Toast
{
/************************************************************************
 * 					Constructor
 ************************************************************************/
	function JapaneseTest()
	{
		parent::Toast(__FILE__); // Remember this
	}

/************************************************************************
 * 			Code to run before and after the tests
 ************************************************************************/
	/**
	 * OPTIONAL; Anything in this function will be run before each test
	 * Good for doing cleanup: resetting sessions, renewing objects, etc.
	 */
	function _pre() {
		$this->load->library("Japanese");
	}

	/**
	 * OPTIONAL; Anything in this function will be run after each test
	 * I use it for setting $this->message = $this->My_model->getError();
	 */
	function _post() {}

/************************************************************************
 * 						Actual test functions
 ************************************************************************/
	function test_isHiragana(){
		$this->_fail("Function has not been implemented yet");
	}
	
	function test_isKatakana(){
		$this->_fail("Function has not been implemented yet");
		
	}
	
	function test_isKana(){
		$this->_fail("Function has not been implemented yet");
		
	}
	
	function test_isKanji(){
		$this->_fail("Function has not been implemented yet");
	}
	
	function test_isRomaji(){
		$this->_fail("Function has not been implemented yet");	
	}
	
	function test_size(){
		$string = "さすが";
		$size 	= "3";
		$result	= $this->japanese->size($string);
		$this->_assert_equals_strict($size, $result);		
	}
	
	function test_kana2romaji(){
		$this->_fail("Function has not been implemented yet");
	}
	
	function test_romaji2kana(){
		$this->_fail("Function has not been implemented yet");
	}
	
	function test_test(){
		$this->_assert_equals_strict(true, $this->japanese->test());
	}
	
	function test_some_actiddddon()
	{
		// Test code goes here
		$my_var = 2 + 2;
		$this->_assert_equals($my_var, 4);
	}

	function test_some_other_action()
	{
		// Test code goes here
		$my_var = true;
		$this->_assert_false($my_var);
	}
}