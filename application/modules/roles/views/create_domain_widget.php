<div>
	<a class="btn btn-lg btn-success" data-toggle="modal" data-target="#newDomainForm"> Create New Domain</a>
	
	<div class="modal fade" id="newDomainForm" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<h3 class="modal-header">Create a new Domain</h3>
				<div class="modal-body">
					<form>
						<div class="form-group">
							<label for="domain_name_input">Domain name</label>
							<input type="text" class="form-control" id="domain_name_input"/>
						</div>
						<div class="form-group">
							<label for="domain_description_input">Domain description</label>
							<textarea class="form-control" id="domain_description_input"></textarea>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               	 	<button type="button" class="btn btn-primary" id="button_create_new_domain"> Validate!</button>
				</div>
			</div>
		</div>
	</div>
	<script>
	//script for attaching the ajax event to the button
		$(function(){
			var Ajax = new Ajax();
			
			//click function for the create_domain button
			var create_domain_click = function(){
				var path 				= 'roles/ajax/create_domain';
				var domainName			= '';
				var domainDescription	= '';
				Ajax.ajaxPostRequest(path, data, responseHandler);

			}
			//get the button and add the click function on it
		});
	</script>
</div>