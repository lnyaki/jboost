<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
require_once 'vendor/autoload.php';

/************************************************************
 * Overview : this class is used to handle all operations
 * 		involving japanese strings (hiragana,katakana,kanji)
 * **********************************************************/
class Japanese {
	
	public function isHiragana($string){
		return false;
	}
	
	public function isKatakana($string){
		return false;
	}
	
	public function isKana($string){
		return $this->isHiragana($string) or $this->isKatakana($string);
	}
	
	public function isKanji($string){
		return false;
	}
	
	public function isRomaji(){
		return false;
	}

	public function kana2romaji($kana){
		return "";
	}
	
	public function romaji2kana($romaji){
		return "";
	}
	
	public function size($string){
		return mb_strlen($string);
	}
	
	public function test(){
		return true;
	}
}
/*End of Japanese.php*/