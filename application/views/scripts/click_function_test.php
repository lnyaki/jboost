<script>
	$button 			= $('#'+click_button);
	$array				= $('#'+click_array);
	console.log(click_array);
	console.log($button);
	
	
	$button.click(function(){console.log('click!');
		$checked_elements 	= $array.find('input[type="checkbox"]:checked');
		_.each($checked_elements,function(elt){
			console.log($(elt).attr('name'));
		})
	});
</script>