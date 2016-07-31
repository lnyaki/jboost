<main id="content">
<?php 
//If only left side and center, we set the left part to 4 and center to 8
	echo "<div class='container-fluid'>";
	echo "<div class='row-fluid'>";
	$span_content = 'col-md-8';
	
	if(isset($_left_aside)){
		$span_left	= 'col-md-4';
		echo "<aside class='$span_left'>".$_left_aside."</aside>";
	}
	if(isset($_content)){
		echo '<div class="'.$span_content.'">'.$_content.'</div>';
	}
	
	echo "</div>";
	echo "</div>";
?>
</main>
