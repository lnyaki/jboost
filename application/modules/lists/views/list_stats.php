<div id="stats-list">
	
	
</div>
<script>
	var $panel;
	var $label;
	var $rowContainer;
	var total = 0;

	var stat_line = function(elt){
		$rowContainer	= $('<div>',{class	: 'elt_stat'});
		total = elt.right+elt.wrong;
		$label			= $('<label style="margin-left : 1em;">'+elt.item+' ('+elt.right+'/'+total+')</label>');
		$progressbar	= $('<progress>',{
							 max	: elt.right+elt.wrong
							,value	: elt.right
		});
		
		$rowContainer.append($($progressbar));
		$rowContainer.append($($label));
		$panel.append($rowContainer)
	}
	
	
	//loop on the stats for each list
	_.forEach(_stat_list, function(elt){
		//create main div for a list
		$panel = $('</div>');
		$panel.addClass("panel panel-default");	
		
		$panel.append("<h3>"+elt.name+"</h3>");
		
		//add each individual result in the list
		_.forEach(elt.content, stat_line(elt));
		
		$('#stats-list').append($panel);
	});

	
	
</script>
