<div class="panel">
	<h1><?php echo (isset($_list_name))? $_list_name: "List";?></h1>
	<div>
	<?php
	/*
		if(isset($_list)){
			foreach($_list as $elt){
				echo "<div>".$elt['item'].$elt['answer']."</div>";
			}
		}
		else{
			echo "No list";
		}
		*/
		$this->load->library('View_generator');
		//set the title array
		$titles = $this->view_generator->initialize_array_title($_list_name);
		//set the links. We want to link the usernames to the user's profile
		//$links = $this->view_generator->create_row_link(null,1,array(1),$prefix);
		$array = $this->view_generator->generate_titled_array($titles,$_list,null,null);
		
		echo $array;
	?>	
	</div>	
</div>