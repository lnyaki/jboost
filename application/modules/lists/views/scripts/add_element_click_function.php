<script>
		var list = new Module.List();
		list.test();
		
		//set click function to the "add element" button
		$('#btn_add_element').click(function(){
			list.echo_text(list.textarea_read("#textArea"));
			//read the lines from the textarea
			var lines = list.textarea_read_line('#textArea');
			//appeler line_to_item en boucle (pour chaque ligne du tableau)
			var tmp = list.lines_to_item(lines,':');
			console.log('item : ');
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