<script>
	
	var ajax = new Ajax();
	//path of the php code to execute
	var path 	= BASE_URL+'test/ajax_test_execution';
	var data	= {};
	var responseHandler	= function(msg){
		var web = new Website();
		console.log(msg);
		$('#content').append('<h3>'+msg+'</h3>');
	};
console.log('domain creation 2');
	ajax.ajaxPostRequest(path,data,responseHandler);
</script>