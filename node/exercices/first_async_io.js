var path = process.argv[2];
var fs = require('fs');



fs.readFile(path,function(err,data){
	
	if(err == null){
		var count = data.toString().split('\n').length-1;
		console.log(count);
	}

});
