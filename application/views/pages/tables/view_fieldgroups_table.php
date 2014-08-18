
<table>
	<thead>
		<tr>
			<th>Group name</th>
			<th>Group Type</th>
			<th>Field</th>
			<th>Format</th>
			<th>Data Type</th>
		</tr>
	</thead>
	<tbody>
		<?php
		
			foreach($_fieldgroups_id as $id){
				$first = true;
				$tmp	= $_fieldgroups[$id->id];
				foreach($tmp as $elt){
					echo '<tr>';
					if($first){
						$span = count($tmp);
						echo '<td rowspan='.$span.'>'.$elt->fieldgroup.'</td>';
						echo '<td rowspan='.$span.'>'.$elt->fg_type.'</td>';
					}
					echo '<td>'.$elt->field.'</td>';
					echo '<td>'.$elt->format.'</td>';
					echo '<td>'.$elt->type.'('.$elt->size.')</td>';
					echo '</tr>';
					$first	= false;
				}
			}
		?>
	</tbody>
</table>