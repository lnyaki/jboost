<div class="panel">
	<h1><?php echo (isset($_list_name))? $_list_name: "List";?></h1>
	<div>
	<?php
		if(isset($_list)){
			foreach($_list as $elt){
				echo "<div>".$elt['item'].$elt['answer']."</div>";
			}
		}
		else{
			echo "No list";
		}
	?>	
	</div>	
</div>