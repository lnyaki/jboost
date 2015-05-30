
module.exports	= function(path,extension,callback_function){
	var fs 			= require('fs');
	

	var callback = function(err,list){
		if(err == null){
			var fileExtension;
			var split;
			var files		= Array();
			
			for(var i = 0; i< list.length;i++){
				split = list[i].split('.');
			
				if(split.length > 1){
					fileExtension = split.pop();
				
					if(fileExtension == extension){
						files.push(list[i]);
					}
				}
			}
			callback_function(null,files);
		}
		else return callback_function(err);
	};

	fs.readdir(path,callback);
};
