<script>
	var ajax = new Ajax();
	
	//path of the php code to execute
	var path 	= 'ajax_test_executionddd';
	var data	= {};
	var responseHandler	= function(msg){
		var web = new Website();
		console.log(msg);
		$('#content').append('<h3>'+msg+'</h3>');
	};

	ajax.ajaxPostRequest(path,data,responseHandler);
			
</script>