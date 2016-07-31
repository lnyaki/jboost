<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administration extends TNK_Controller {
	
	public function tools(){
		
	}
	
	//Load kanji from kanjidic.xml
	public function load_KanjiDic($dictionary){
		//$dictionary = "kanjidic2.xml";
		$dom = new DOMDocument();

		//Loading the dictionary file
		if($dom->load($dictionary)){
			$entriesList = $dom->getElementsByTagName('character');
	
			$j=0;
			
			//For each Kanji entry
			foreach($entriesList as $entry) {
				//$literal = $entry->item(0);
				
				//Get the kanji element (tag <literal>)
				$kanji = $entry->getElementsByTagName('literal')->item(0)->nodeValue;
				
				echo $kanji;
				echo '<br/>';
				
				//Get all the radicals. Contains one ore more (+) rad_value (which is the number of
				//the radical(s) that compose this kanji, going from 1 to 214).
				
				
				//Get all the miscelaneous information
				
				
				//Get the reference to where this character is presented in other dictionaries
				
				//Get all the meanings
				$meanings = $entry->getElementsByTagName('reading_meaning');
				foreach($meanings as $meaning){
					if(!$meaning->hasAttribute('m_lang')){
						echo $meaning->nodeValue;
						echo '<br/>';
					}
				}
		
			$readings = $entry->getElementsByTagName('reading');
			$readingsOn;
			$readingsKun;
		
			foreach($readings as $reading){
				if($reading->hasAttribute('r_type')){
					
					if($reading->getAttribute('r_type') == 'ja_kun'){
						$readingsKun[] = $reading->nodeValue;
						echo 'Kun : ' . $reading->nodeValue;
						echo '<br/>';
					}
					else if($reading->getAttribute('r_type') == 'ja_on'){
						$readingsOn[] = $reading->nodeValue;
						echo 'On : ' . $reading->nodeValue;
						echo '<br/>';
					}
				
				}
			}
		
			addKanji($kanji, $meanings, $readingsOn, $readingsKun);
			
			$j++;

			if($j == 10) break;
			}
		}
		else{
    		echo "The XML file could not be loaded :$dictionary";
		}
	}
	
	//Load entries from JMDict dictionary
	public function load_dicitonary($filepath){
		
	}
}