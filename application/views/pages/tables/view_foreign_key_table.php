
<table>
	<thead>
		<tr><?php echo $_tablename;?></tr>
		<tr><th>Field</th><th>Format</th><th>Type</th><th>Description</th></tr>
	</thead>
	<tbody>
	<?php
		if(isset($_fields)){
			$max	= count($_fields);
			for($i = 0; $i<$max; $i++){
				$tmp	= $_fields[$i];
				echo '<tr><td>'.$tmp['field'].'</td><td>'.$tmp['format'].'</td><td>N/A</td><td>'.$tmp['descritpion'].'</td></tr>';
			}	
		}
	
	?>
	</tbody>
</table>