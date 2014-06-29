
<table>
	<thead>
		<tr><th colspan="3"><?php echo $_tablename;?></th></tr>
		<tr>
			<th>Field</th>
			<th>Format</th>
			<th>Type</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach($_fields as $field){
				echo '<tr>';
				echo '<td>'.$field->field.'</td>';
				echo '<td>'.$field->format.'</td>';
				echo '<td>'.$field->type.'('.$field->size.')</td>';
				echo '</tr>';
			}
			
		?>
		<tr></tr>
	</tbody>
</table>