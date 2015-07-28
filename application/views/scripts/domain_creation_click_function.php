<script>
	//script for attaching the ajax event to the button
	$(function(){
			var ajax = new Ajax();
			//click function for the create_domain button
			var create_domain_click = function(){
			//path of the php code to execute
			var path 				= 'roles/ajax/create_domain';
			
			//get the form data
			var domainName			= $('#domain_name_input').val();
			var domainDescription	= $('#domain_description_input').val();
			
			//get the modal element
			var $modal	= $('#newDomainForm');

			console.log($('#domain_name_input'));
			console.log($('#domain_description_input'));
			
			//parameters object
			data =	{'name' 		: domainName,
					'description'	: domainDescription};
			
			//Function to handle the response
			var responseHandler = function(msg){
				console.log('Response Handler');
				console.log(msg);
			}
			
			ajax.ajaxPostRequest(path, data, responseHandler);

			$modal.modal('toggle');
		}
			
		$('#button_create_new_domain').click(create_domain_click);
		//get the button and add the click function on it
	});
</script>