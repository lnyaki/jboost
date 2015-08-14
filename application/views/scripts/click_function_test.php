<script>
	$button 			= $('#'+click_button);
	$array				= $('#'+click_array);
	console.log(click_array);
	console.log($button);
	
	
	$button.click(function(){
		console.log('click!');
		var tab = new Array();
		$checked_elements 	= $array.find('input[type="checkbox"]:checked');
		_.each($checked_elements,function(elt){
			console.log($(elt).attr('name'));
			tab.push($(elt).attr('name'));
		});
		
		var ajax = new Ajax();
		var path = BASE_URL+'ajax/quizz/test_ajax';
		var responseHandler = function(msg){
			console.log('Message retourné :');
			console.log(msg);
		}
		ajax.ajaxPostRequest(path,{'data' : tab},responseHandler);
	});
</script>