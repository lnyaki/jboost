<div>
	<?php
		if(isset($_users)){
			$this->load->library('View_generator');
			
			if(count($_users)>0){
				//set the title array
				$titles = $this->view_generator->initialize_array_title('User List');
				//set the links. We want to link the usernames to the user's profile
				$prefix = base_url().'users';
				$links = $this->view_generator->create_row_link(null,2,array(2),$prefix);
				$array = $this->view_generator->generate_titled_array($titles,$_users,null,$links);
				
				echo $array;
			}	
			else{
				echo '<h3>Users</h3>';
				echo '<p>The list of users is empty</p>';
			}
		}		

	?>
</div>