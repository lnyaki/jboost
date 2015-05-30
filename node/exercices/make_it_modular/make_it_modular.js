var path 		= process.argv[2];
var extension	= process.argv[3];

var filter = require('./filter_module.js');

filter(path,extension,function(err,data){
	for(var i = 0;i<data.length;i++){
		console.log(data[i]);
	}
});
