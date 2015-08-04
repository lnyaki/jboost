<script>
	//script for attaching the ajax event to the button
	//(function(){
		var ajax = new Ajax();
		//var path 	= BASE_URL+'test/ajax_test_execution';
		var path 				= BASE_URL+'ajax/roles/create_domain';

		var create_domain_click2 = function(){
			var data = {};

			var responseHandler = function(msg){
				var web = new Website();
				console.log(msg);
				$('#content').append(msg);
			}
			ajax.ajaxPostRequest(path, data, responseHandler);
		
		};
			
			
			
			
			
			
			//click function for the create_domain button
			var create_domain_click = function(){
				//path of the php code to execute
				//var path 				= 'roles/ajax/create_domain';
				//var path = 'test/ajax_tddest_execution';
				//get the form data
				var domainName			= $('#domain_name_input').val();
				var domainDescription	= $('#domain_description_input').val();
			
				//get the modal element
				var $modal	= $('#newDomainForm');
			
				//parameters object
				data =	{'name' 		: domainName,
						'description'	: domainDescription};
			
				//Function to handle the response
				var responseHandler = function(msg){
					console.log('Message : '+msg);
					var web = new Website();

				if(msg == '1'){
					console.log('Message OK');
					//output ok alert
					var id = 'alert-success-domain';
					var content = 'Domain <b>'+domainName+'</b> has been successfully created.';
					
					var $alert;
					//if not already exist, we append the alert. Otherwise, we get the existing
					//alert and change its content
					if ($('#'+id).length == 0){
						$alert = web.alert_success(content,id);
						$('body').append($alert);
					}
					else{
						$alert = $('#'+id);
						$alert.text(content);
					}
	
					web.alert_show_delay(id,500);
					web.alert_hide_delay(id,3500);
					
				}
				else{
					console.log(' Message Ko');

					//output ko.
					var id = 'alert-error-domain';
					var content = 'Domain <b>'+domainName+'</b> could NOT be created.';
					var $alert = web.alert_danger(content,id);
	
					web.alert_show_delay(id,500);
					web.alert_hide_delay(id,3500);
					$('body').append($alert);
				}
				
				//reinitialize form
				$('#domain_name_input').val('');
				$('#domain_description_input').val('');
			}
			
			ajax.ajaxPostRequest(path, data, responseHandler);

			$modal.modal('toggle');
		}
		
		//get the button and add the click function on it
		$('#button_create_new_domain').click(create_domain_click);
		
	//});
</script>