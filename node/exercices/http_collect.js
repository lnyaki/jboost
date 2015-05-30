var url = process.argv[2];
var http = require('http');
var text = '';

var function_error = function(data){

};

var function_data = function(data){
	text += data;
};

var function_end = function(data){
	console.log(text.length);
	console.log(text);
};


var callback = function(response){
	response.setEncoding('utf8');

	response.on('error',function_error);
	response.on('data',function_data);
	response.on('end',function_end);
};

http.get(url,callback);
