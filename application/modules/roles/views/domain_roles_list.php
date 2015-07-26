<div>
	<?php
		if(isset($_roles)){
			$this->load->helper('my_array');
			$list = '';
			
			if(count($_roles)>0){
				echo '<h3>Domain : '.$_roles[0]->domain.'</h3>';
				//get array  head
				$thead = html_table_head(array_keys((array)$_roles[0]));
				
				//get array body
				$tbody = html_table_body($_roles);
				
				$table = html_table($thead,$tbody,'table table-hover');
				
				echo $table;
			}
			
		}
	?>
</div>