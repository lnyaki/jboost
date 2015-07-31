<div>Hello</div>

<div>
	<?php
		if(isset($_domains)){
			/*echo "<h3>Domains</h3>";
			$list = '';
			foreach($_domains as $domain){
				$list .= '<li><a href="/roles/domains/'.$domain->name.'">'.$domain->name.'</a></li>';
			}
			
			$list = '<ul>'.$list.'</ul>';
			
			echo $list;*/
			
			echo '<h3>Domains : </h3>';
				//get array  head
			if(isset($_domains) and count($_domains)>0){
				$this->load->helper('my_array');
			
				$thead = html_table_head(array_keys((array)$_domains[0]));
				
				$links = array(base_url().'roles/domains/',2);
				//get array body
				$tbody = html_table_body($_domains,null,null,$links);
				
				$table = html_table($thead,$tbody,'table table-hover');
				
				echo $table;
			}
		}
	?>
</div>