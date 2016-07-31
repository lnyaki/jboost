<main id="content">
<?php 
	echo "<div class='container-fluid'>";
	echo "<div class='row-fluid'>";
	$span_content = 'col-md-12';
	
	if(isset($_content)){
		echo '<div class="'.$span_content.'">'.$_content.'</div>';
	}
	
	echo "</div>";
	echo "</div>";
?>
</main>
