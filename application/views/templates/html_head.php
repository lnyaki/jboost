
	<?php
	if(isset($_css)){
		$max	= count($_css);
		foreach($_css as $css){
			echo ' <link rel="stylesheet" href="'.$css.'" />';
		}	
	}
	?>
