<div class="panel">
	<h1 >Kana Lists</h1>
	<?php 
	
	//<div class="panel panel-default">
	//build the html table 
			
	if(isset($_thead) and isset($_tbody)){
		$table_class = isset($_table_class)? $_table_class : '';
		
		echo html_table($_thead,$_tbody, $table_class);
	}
	//echo "test content";
	
	?>
</div>