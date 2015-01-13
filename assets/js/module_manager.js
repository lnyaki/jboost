//this class handles modules
var manager = (function(){
	
	var Manager = function(){};
	
	Manager.prototype = (function(){
		var constructor = Manager;
			
		//object for the modules
		var _modules	= {};
		

		//add the js for a specific module
		var add_module	= function(module){
			_.assign(modules,module);
		};
		

		var get_module	= function(module){
			return _modules[module];
		};
		
		return {
			 add_module		: add_module
			,get_module		: get_module
		};
	})();
	
	return {
		Manager : Manager	
	};
})();
