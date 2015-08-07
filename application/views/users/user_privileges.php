<div>
	<?php
		if(isset($_privileges)){
			$this->load->helper('my_array');
			$list = '';
			
			if(count($_privileges)>0){
				echo '<h3>Privileges </h3>';

				//get array  head
				$thead = html_table_head(array_keys((array)$_privileges[0]));
				
				$links = array(base_url().'roles/',3);
				//get array body
				$tbody = html_table_body($_privileges,null,null,null);
				
				$table = html_table($thead,$tbody,'table table-hover');
				
				echo $table;
			}
			else{
				echo "<h3>Privileges :</h3>";
				echo "<p>This user doesn't have any privileges.";
			}
			
		}
	?></div>