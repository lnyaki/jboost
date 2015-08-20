<div>
	<?php
		if(isset($_privileges)){
			$this->load->helper('my_array');
			$list = '';
			
			if(count($_privileges)>0){
				echo '<h3>User Privileges </h3>';
				
				$this->load->library("View_generator");
				echo $this->view_generator->generate_array($_privileges);
			}
			else{
				echo "<h3>Privileges :</h3>";
				echo "<p>This user doesn't have any privileges.";
			}
			
		}
	?></div>