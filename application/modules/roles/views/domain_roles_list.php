<div>
	<?php
		if(isset($_roles)){
			$this->load->library('View_generator');
		
			if(count($_roles)>0){
				$domainName = $_roles[0]->domain;
				echo '<h3>Domain : '.$domainName.'</h3>';
	
				//Test the new sub arrays function
				//Set the prefix to use, for the links (<a>)
				$prefix = base_url()."domains/$domainName";
				$sub_array = $this->view_generator->get_sub_arrays($_roles,array(2));
		
				
				//Set the links, before passing them in generate arrays
				$links = $this->view_generator->create_row_link(null,3,array(3),$prefix);
				//Set the prefix to use, for the links (<a>)
				$titles = $this->view_generator->initialize_array_title('',2,'Role :',' :-)');				
				foreach($sub_array as $rol){
					
					echo $this->view_generator->generate_titled_array($titles,$rol,array(1),$links,'');
				}
			}
			else{
				echo "<h3>Domain : Empty domain</h3>";
				echo "<p>This domain is empty. It doesn't contain any role.";
			}
			
		}
	?>
</div>