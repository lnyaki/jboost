//required : lodash.js

var module = (function(){
	
	var Module = function(){};
	
	Module.prototype = (function(){
		var constructor = Module;
		
		//variable that will contain the different classes in the module.
		var _classes = {};
	
		//add a class to this module
		var add_class = function(class_object, class_name){
			var retour = true;
		
			//if the class name is already taken
			if(_.has(_classes,class_name)){
				retour = false;
			}
			else{
				_classes[class_name] = class_object;
				retour = true;
			}
		
			return retour;
		};
	
		//return the class object named "the class"
		var get_class = function(the_class){
			return (_.has(_classes,the_class))? _.classes[the_class]: false;
		};
	
		return {
		 	add_class : add_class
			,get_class : get_class
		};
	})();
		
	
})();
