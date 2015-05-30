var port 	= process.argv[2];
var path 	= process.argv[3];

var fs 		= require('fs');
var http 	= require('http');

var stream 	= fs.createReadStream(path);

var http_callback	= function(request,response){
	stream.pipe(response);
};


var server	= http.createServer(http_callback);

server.listen(port);
