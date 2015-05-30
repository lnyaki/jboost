var url = process.argv[2];
var http = require('http');


var function_error = function(err,data){

};

var function_data = function(data){
	console.log(data);
};

var function_end = function(err,data){
	
};


var callback = function(response){
	response.setEncoding('utf8');

	response.on('error',function_error);
	response.on('data',function_data);
	response.on('end',function_end);
};

http.get(url,callback);
