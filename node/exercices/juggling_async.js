var url1 = process.argv[2];
var url2 = process.argv[3];
var url3 = process.argv[4];
var http = require('http');
var text1 = '';
var text2 = '';
var text3 = '';
var completed = 0;


var function_data1 = function(data){
	text1 += data;
};

var function_end = function(data){
	completed++;
	if(completed == 3){
		console.log(text1);
		console.log(text2);
		console.log(text3);
	}
};


var function_data2 = function(data){
	text2 += data;
};

var function_data3 = function(data){
	text3 += data;
};




var callback1 = function(response){
	response.setEncoding('utf8');

	response.on('data',function_data1);
	response.on('end',function_end);
};

var callback2 = function(response){
	response.setEncoding('utf8');

	response.on('data',function_data2);
	response.on('end',function_end);
};

var callback3 = function(response){
	response.setEncoding('utf8');

	response.on('data',function_data3);
	response.on('end',function_end);
};

http.get(url1,callback1);
http.get(url2,callback2);
http.get(url3,callback3);