<script>

	window.setTimeout(function () {
    	$('#alert8').addClass('in');
	}, 2000);

	window.setTimeout(function(){
		$('#alert8').removeClass('in');
	},5000);


	var web = new Website();
	var id = 'alert-success';
	var content = 'Le nouveau contenu Hello';
	var $alert = web.alert_success(content,id);
	
	web.alert_show_delay(id,500);
	web.alert_hide_delay(id,2000);
	$('body').append($alert);
	
	$('.modal-backdrop').css('opacity','0.5');
	//$('body')[0].append($alert);
</script>