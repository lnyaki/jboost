<div id="content">
<?php 
	if(isset($_left_aside)){
		echo "<aside>".$_left_aside."</aside>";
	}
	
	if(isset($_content)){
		echo $_content;
	}
	
	if(isset($_right_aside)){
		echo "<aside>".$_right_aside."</aside>";
	}
	
?>
</div>
