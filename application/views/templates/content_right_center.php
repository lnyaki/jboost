<main id="content">
<?php 
	echo "<div class='container-fluid'>";
	echo "<div class='row-fluid'>";
	$span_content = 'col-md-8';
	
	if(isset($_content)){
		echo '<div class="'.$span_content.'">'.$_content.'</div>';
	}
	if(isset($_right_aside)){
		$span_right	= 'col-md-4';
		echo "<aside class='$span_right'>".$_right_aside."</aside>";
	}
	
	echo "</div>";
	echo "</div>";
?>
</main>
