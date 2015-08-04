<script>
	var module = module || {};
	
	module.Ajax = Ajax;
	module.Website = Website;
	
	(function(modules){
		var ajax = new modules.Ajax();
		
		var new_role_click = function(){
			console.log('click on new role');
			//path of the php code to execute
			var path 				= BASE_URL+'ajax/roles/create_role';
			//get the form data
			var roleName			= $('#role_name_input').val();
			//the domainID is already set in the html/javascript of the page
			
			
			//get the modal element
			var $modal	= $('#newRoleForm');
			
			//parameters object
			data =	{'name' 	: roleName
					,'domainID'	: domainID};
			
			//function that handles the ajax response
			var responseHandler	= function(msg){
				var web = new modules.Website();
				console.log("Here is the return");
				console.log(msg);
				//if request is successfull
				if(msg == '1'){
					//alert element
					var id = 'alert-success-role';
					var alert_content	= 'Role <em>'+roleName+'</em> has been successfully added to domain... ';
					
					var $alert;
					
					//if not already exist, we append the alert. Otherwise, we get the existing
					//alert and change its content
					if($('#'+id).length == 0){
						$alert = web.alert_success(alert_content,id);
						$('body').append($alert);
					}
					else{
						$alert	= $('#'+id);
						$alert.text(alert_content);
					}
					
					//intitialize the alert delay
					web.alert_show_delay(id,500);
					web.alert_hide_delay(id,3500);
				}
				//if request is not successfull (but maybe that must be handled in the "error" function)
				else{
					console.log(' Message Ko');
					
					//output ko.
					var id = 'alert-error-role';
					var content = 'Role <em>'+roleName+'</em> could NOT be created.';
					var $alert = web.alert_danger(content,id);
	
					web.alert_show_delay(id,500);
					web.alert_hide_delay(id,3500);
					$('body').append($alert);
				}
				//reinitialize form
				$('#role_name_input').val('');
			};
			ajax.ajaxPostRequest(path,data,responseHandler);
			
			$modal.modal('toggle');
		};
		
		//get the button and add the click function on it
		$('#button_create_new_role').click(new_role_click);
	}(module));
</script>