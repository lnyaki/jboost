<main id="content">
<?php 
	if(isset($_left_aside)){
		echo "<aside style='float:left;'>".$_left_aside."</aside>";
	}
	if(isset($_right_aside)){
		echo "<aside style='float: right;'>".$_right_aside."</aside>";
	}
	if(isset($_content)){
		echo '<div class="center">'.$_content.'</div>';
	}
	
?>
</main>
