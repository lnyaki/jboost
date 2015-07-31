<div>
	
	<a href="#" class="btn btn-lg btn-success" data-toggle="modal" data-target="#myModal">Open Modal</a>

	<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">Hello</div>
				<div class="modal-body">world</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               	 	<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>

</div>
<script>
	function showAlert(id){
  		$("#"+id).addClass("in")
	}
	
	function hideAlert(){
		
	}
	
	window.setTimeout(function () {
    	showAlert('alert');
	}, 2000);
	
	
	window.setTimeout(function () {
    	showAlert('alert2');
	}, 2000);
</script>