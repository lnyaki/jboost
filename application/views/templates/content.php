<main id="content">
<?php 
	echo "<div class='container-fluid'>";
	echo "<div class='row-fluid'>";
	$span_content = 'col-md-8';
	
	if(isset($_left_aside)){
		$span_left	= 'col-md-2';
		echo "<aside class='$span_left'>".$_left_aside."damn it</aside>";
	}
	if(isset($_content)){
		echo '<div class="'.$span_content.'">'.$_content.'</div>';
	}
	if(isset($_right_aside)){
		$span_right	= 'col-md-2';
		echo "<aside class='$span_right'>".$_right_aside."damn it 2</aside>";
	}
	
	echo "</div>";
	echo "</div>";
?>
</main>
