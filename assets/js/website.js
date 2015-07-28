var Website = function(){
	
};

Website.prototype = (function(){
	var constructor = Website;
	
	var alert_success	= function(content,id){
		//set a default value for id
		id = typeof id !== 'undefined'? id : 'alert-success';
		$alert_button	= $('<button type="button"  class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
		$alert_element	= $('<div id="'+id+'" class="alert alert-success customAlert fade alert-dismissible" role="alert">');
		$alert_element.append($alert_button);
		$alert_element.text(content);

		console.log("alert success");
		console.log($alert_element);
		
		return $alert_element;
	};
	
	var alert_show_delay = function(elementID,delay){	
		window.setTimeout(function () {
    		$('#'+elementID).addClass('in');
		}, delay);
	};
	
	var alert_hide_delay = function(elementID,delay){
		window.setTimeout(function () {
    		$('#'+elementID).removeClass('in');
		}, delay);
	};

	return {
		alert_success 		: alert_success
		,alert_show_delay	: alert_show_delay
		,alert_hide_delay	: alert_hide_delay
	};
})();
