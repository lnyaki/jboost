

<table>
	<thead>
		<?php
		echo '<tr><th>Table</th><th>Encoding</th><th>Type</th><th>Description</th></tr>';
		?>
	</thead>
	<tbody>
		<?php
		if(isset($_table_list)){
			$max	= count($_table_list);
			for($i = 0; $i<$max; $i++){
				$tmp	= $_table_list[$i];
				echo '<tr><td><a href=\'display_table/'.$tmp->id.'/'.$tmp->name.'\'>'.$tmp->name.'</a></td><td>'.$tmp->encoding.'</td><td>'.$tmp->type.'</td><td>'.$tmp->description.'</td></tr>';
			}
		}
		?>
	</tbody>
</table>