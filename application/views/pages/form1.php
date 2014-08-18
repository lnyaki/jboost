<div>Form1.php : 
	<?php 
		//check and initialisation
		$content = (isset($content))?$content: '';
		$form2 = (isset($form2))?$form2: '';
		$form3 = (isset($form3))?$form3: '';

		echo get_class($this);
		echo $content;
		echo $form2;
		echo $form3;
		
		$elt = 'contffent';
		if (isset(${$elt})){
			echo "$".$elt." is set - 1<br/>";
		}
		else{
			echo "$".$elt." is not set - 1<br/>";
		}
		
		$this->toto($elt);
	?>
		
</div>