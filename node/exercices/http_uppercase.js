var port 	= process.argv[2];
var map 	= require('through2-map');
var http 	= require('http');

var to_uppercase	= function(data){
	return data.toUpperCase();
};

var http_callback	= function(request,response){
	if(request.method == 'POST'){
		request.pipe(map({wantStrings: true},to_uppercase)).pipe(response);
	}
};

var server	= http.createServer(http_callback);
server.listen(port);