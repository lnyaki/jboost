<div class ="panel">
	<h1>Create a new list</h1>
	<form action="process/create/" method="post">
		<div class="row">
			<label>List name : <input type='text' name="list"></input></label>
		</div>
		<div class="row">
			<div class="col-md-5">
				<textarea id="textArea" style="width : 100%;"></textarea>
			</div>
			<div class="col-md-2">
				<button type="button" name="testtest" id="btn_add_element" class="btn btn-primary">Add elements</button>
			</div>
			<div class="col-md-5">
		<!--	<textarea style="width : 100%;"></textarea> -->
				<select multiple name="items[]" id="select" style="width : 100%;height : 30em;">
				</select>
			</div>
		</div>
		<div class="row">
			<div class= "col-md-3">
				<button type="submit" name="btn_create_list" id="btn_create_list" class="btn btn-primary">Create list</button>
			</div>
		</div>
	</form>
</div>
