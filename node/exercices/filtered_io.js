var fs 			= require('fs');
var path 		= process.argv[2];
var extension	= process.argv[3];

var callback = function(err,list){
	if(err == null){
		var fileExtension;
		var split;
		for(var i = 0; i< list.length;i++){
			split = list[i].split('.');
			
			if(split.length > 1){
				fileExtension = split.pop();
				
				if(fileExtension == extension){
					console.log(list[i]);
				}
			}
		};
	}
};

fs.readdir(path,callback);
