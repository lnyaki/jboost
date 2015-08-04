<div>
	<a class="btn btn-lg btn-success" data-toggle="modal" data-target="#newRoleForm"> Create New Role</a>
	
	<div class="modal fade" id="newRoleForm" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<h3 class="modal-header">Create a new Role</h3>
				<div class="modal-body">
					<form>
						<div class="form-group">
							<label for="role_name_input">Role name</label>
							<input type="text" class="form-control" id="role_name_input"/>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               	 	<button type="button" class="btn btn-primary" id="button_create_new_role"> Validate!</button>
				</div>
			</div>
		</div>
	</div>
</div>