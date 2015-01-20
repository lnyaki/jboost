<div class ="panel">
	<h1>Create a new list</h1>
	<div class="row">
		<label>List name : <input type='text'></input></label>
	</div>
	<div class="row">
		<div class="col-md-5">
			<textarea id="textArea" style="width : 100%;"></textarea>
		</div>
		<div class="col-md-2">
			<button id="btn_add_element" class="btn btn-primary">Add elements</button>
		</div>
		<div class="col-md-5">
		<!--	<textarea style="width : 100%;"></textarea> -->
			<select multiple id="select" style="width : 100%;height : 30em;">
				<option value="test1"> Test 1 </option>
				<option value="test2"> Test 2</option>
				<option value="test3"> Test 3</option>
				<option value="test4"> Test 4</option>

			</select>
		</div>
	</div>
	<div class="row">
		<div class= "col-md-3">
			<button class="btn btn-primary">Create list</button>
		</div>
	</div>
	<script>
		var list = new Module.List();
		list.test();
		
		var test = "Hello";
		var regex = new RegExp('e*l');
		console.log("test regex : "+regex.test(test));
		//set click function
		$('#btn_add_element').click(function(){
			list.echo_text(list.textarea_read("#textArea"));
			list.add_element_array($('#select'),'toto','List item!');
		});
	</script>
</div>
