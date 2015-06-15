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
	<script>
		/*var list = new Module.List();
		list.test();
		
		var test = "Hello";
		var regex = new RegExp('e*l');
		console.log("test regex : "+regex.test(test));
		*/
		//set click function to the "add element" button
		$('#btn_add_element').click(function(){
			list.echo_text(list.textarea_read("#textArea"));
			//read the lines from the textarea
			var lines = list.textarea_read_line('#textArea');
			//appeler line_to_item en boucle (pour chaque ligne du tableau)
			var tmp = list.lines_to_item(lines,':');
			console.log(tmp);
			
			//add the items to the list
			list.add_array_list('#select',tmp);
			//empty the textarea
			$('#textArea').val('');
			
			//select all the elements in the list
			console.log("In the click function : Test");
			
		});
		
		//set the click function to the "create list" button
		$('#btn_create_list').click(function(){
			
			list.select_all_elements('#select');
		});
	</script>
</div>
