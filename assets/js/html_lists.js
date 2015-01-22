/*
 * List object to handle operations on item lists
 * 
 * Require : lodash, jquery
 */
var Module	= {};

Module.List = (function(){
		var List = function(){
			console.log("New list created!");
		};
	
		List.prototype = (function(){
			var constructor = List;
		
			//generate a pair of input fields for the list creation/update form
			var generate_list_input_boxes	= function(){
			};
		
		
			var test = function(){
				console.log("-== Hello, in test function ==-");
			};
		
			//return an array of the content of the textarea
			var textarea_read_line	= function(selector){
				return $(selector).val().split('\n');
			};
			
			//take a line a return an item containing a key and a value
			var line_to_item		= function(line,separator){
				//test if the separator exists in the line
				var regex = new RegExp(separator);
				var key,value;
				
				//if separator exists in the line
				if(regex.test(line)){
					var index	= line.indexOf(separator);
					key		= line.substr(0,index);
					//returns empty string if we go out of bounds
					value	= line.substr(index+1);
				}
				//if separator doesn't exist, the whole line is the key.
				else{
					key 	= line;
					value 	= '';
				}
				
				//return an item
				return {
						key 	: key
					,	value	: value
				};
				 	
			};
			
			//take an array of lines and return an array of key/value objects
			var lines_to_item	= function(lines,separator){
				var result = new Array();
				
				_.each(lines,function(line){
					result.push(line_to_item(line,separator));
				});
				
				return result;
			};
			
			var textarea_read		= function(selector){
				return $(selector).val();
			};
			
			var echo_text			= function(text){
				console.log("***** Echo text ****");
				console.log(text);
			};
			
			var add_element_list = function(list,value,content){
				$(list).append('<option value='+value+'>'+content+'</option>');
			};
			
			//add an array of item to the html select element (list)
			var add_array_list 		= function(list,items){
				console.log(items);
				_.each(items,function(elt){
					$(list).append('<option value='+elt.key+'>'+elt.key+' --> '+elt.value+'</option>');
				});
			};
			
			return {
				 test : test
				,textarea_read_line : textarea_read_line
				,textarea_read		: textarea_read
				,echo_text			: echo_text
				,add_element_list	: add_element_list
				,add_array_list		: add_array_list
				,line_to_item		: line_to_item
				,lines_to_item		: lines_to_item
			};
		})();
	
	return List;
	})();
	
	