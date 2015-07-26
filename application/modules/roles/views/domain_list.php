<div>Hello</div>

<div>
	<?php
		if(isset($_domains)){
			echo "<h3>Domains</h3>";
			$list = '';
			foreach($_domains as $domain){
				$list .= '<li><a href="/roles/domains/'.$domain->name.'">'.$domain->name.'</a></li>';
			}
			
			$list = '<ul>'.$list.'</ul>';
			
			echo $list;
		}
	?>
</div>