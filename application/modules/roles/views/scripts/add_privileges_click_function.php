<script>
//Get data passed to this view
<?php
	$_userID = isset($_userID)? $_userID:'';
	$_buttonID	= isset($_buttonID)? $_buttonID:'';
	$_contextID	= isset($_contextID)? $_contextID:'';
	echo "var userID 	= '$_userID';\n";
	echo "var buttonID	= '$_buttonID';\n";
	echo "var contextID = '$_contextID';\n";
?>
//contextID is previously set up in the controller roles/privileges
	var $context 	= $('#'+contextID);
	
//buttonID is previously set up in the controller roles/privileges
	var $button 	= $('#'+buttonID);
	
	//Create the click function
	var privileges_click_function	= function(){
		var $checkboxes		= $context.find('input[type="checkbox"]:checked');
		var elements_array	= new Array();
		//we take data from each selected checkbox
		_.each($checkboxes,function(element){
			//get the data from checkboxes
			var domainID	= $(element).attr('domainID');
			var privilege	= $(element).attr('privilege');
			var userID		= $(element).attr('userID');
			elements_array.push({'domainID': domainID
								,'privilege': privilege
								,'userID': userID}
							);
		});
		
		var ajax = new Ajax();
		var path = BASE_URL+'ajax/roles/add_privilege_to_user';
		/*
		_.each(elements_array,function(elt){
			console.log(elt);
		})
		*/
		var responseHandler	= function(msg){
			console.log('Messsage retourné');
			console.log(msg);
		};
		ajax.ajaxPostRequest(path,{'data' : elements_array},responseHandler);
	};
	
	//attach the click function
	$button.click(privileges_click_function);
</script>