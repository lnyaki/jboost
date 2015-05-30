
<div>
	<?php
		if(isset($_list)){
			echo "<h3> Hiragana List";
			if(isset($_list['listname'])){
				echo $_list['listname'];
				
			}
			echo "</h3>";
			echo "<div style='width : 600px;'>";
			
			$content = '';

			foreach($_list as $row){
				$total = $row->ok + $row->ko;
				echo "<div class='elt_stat inline' style='text-align:center;'>";
				echo "<div style='margin:auto;'><span class='character'>$row->kana_ref</span><span class='stats_number'>($row->ok/$total)</span></div>";
				echo "<progress max='$total' value='$row->ok'></progress>";
				//echo "<label style='margin-left : .5em;'>$row->kana_ref ($row->ok/$total)</label>";
				echo "</div>";	
				
				/*
				$rowContainer	= $('<div>',{class	: 'elt_stat'});
				$label			= $('<label style="margin-left : 1em;">'+elt.item+' ('+elt.right+'/'+total+')</label>');
				$progressbar	= $('<progress>',{
					 max	: elt.right+elt.wrong
					,value	: elt.right
				});*/
			}
			
			echo "</div>";
		}
	?>
</div>