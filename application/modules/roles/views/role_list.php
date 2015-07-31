
<div>
	<?php
		if(isset($_roles)){
			echo '<h3>Roles : </h3>';
			//get array  head
			if(isset($_roles) and count($_roles)>0){
				$this->load->helper('my_array');
			
				$thead = html_table_head(array_keys((array)$_roles[0]));
				
				//$links = array(base_url().'roles/domains/',2);
				$links = null;
				//get array body
				$tbody = html_table_body($_roles,null,null,$links);
				
				$table = html_table($thead,$tbody,'table table-hover');
				
				echo $table;
			}
		}
	?>
</div>