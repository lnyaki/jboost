//****************************************************************************
//                           AJAX
//
//****************************************************************************
	var Ajax		= function(){};

	Ajax.prototype	= (function(){
		var constructor	= Ajax;
		//create an ajax request of type get
    	var ajaxGetRequest = function(path, responseHandler){
        	ajaxRequest(path, null, responseHandler, 'get');
    	};
    
    	//create an ajax request of type post
    	var ajaxPostRequest = function(path, data, responseHandler){
       	 	ajaxRequest(path, data, responseHandler, 'post');
    	};
    
    	//create an ajax request.
    	var ajaxRequest = function(path, data, responesHandler, type){
        	datatype = 'json';
        	$(document).ajaxError(function(event, jqxhr, settings, thrownError){
				console.log("-----------======== [AJAX error] =======-------------");
				console.log(event);
				console.log(jqxhr);
				console.log(settings);
				console.log(thrownError);
				console.log("-----------======== [/AJAX error] =======-------------");
			});
        
        	if(type==='get'){
            	$.ajax({
                    url			:path
                ,   datatype	:datatype
                ,   type		:'get'
                ,   success		:function(data){
                        responesHandler(data);
                	}
            });
        	}
        	else if(type==='post'){
            	$.ajax({
                    url			: path
                ,   datatype 	: datatype
                ,   type		:'post'
                ,   data		: data
                ,   success 	: function(msg){
                        responesHandler(msg);
                	}
            	});    
        	}
    	};
		
		var setError	= function(callback){
			datatype = 'json';
        	$(document).ajaxError(function(event, jqxhr, settings, thrownError){
				console.log("-----------======== [AJAX error] =======-------------");
				console.log(event);
				console.log(jqxhr);
				console.log(settings);
				console.log(thrownError);
				console.log("-----------======== [/AJAX error] =======-------------");
			});
		};
		
		return {
			ajaxGetRequest		:ajaxGetRequest
			,ajaxPostRequest	:ajaxPostRequest
			,setError			: setError
		};
	})();

