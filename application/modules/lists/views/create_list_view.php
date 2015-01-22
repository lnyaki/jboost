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
			//list.add_element_array($('#select'),'toto','List item!');
			var lines = list.textarea_read_line('#textArea');
			//appeler line_to_item en boucle (pour chaque ligne du tableau)
			var tmp = list.lines_to_item(lines,':');
			console.log(tmp);
			
			list.add_array_list('#select',tmp);
			
			list.add_array_list('#textArea',lines);
			
		});
	</script>
</div>
