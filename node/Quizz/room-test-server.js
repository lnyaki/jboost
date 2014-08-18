	var PORT			= 8080;
	var http 		= require('http');
	var fs 			= require('fs');
	 //create the server object
	 server = http.createServer(function(req, res){
	 	fs.readFile('./room-test.html', 'utf-8', function(error, content) {
      		res.writeHead(200, {"Content-Type": "text/html"});
       		res.end(content);
    	});
	 });
			 
	 //listen on the chosen port
	 io = require('socket.io').listen(server);
	 //set listening port
	 server.listen(PORT);
	

	console.log("*********************************************");
	console.log("*****          SERVER STARTING         ******");
	console.log("*********************************************");

	//on connection
	io.sockets.on('connection',function(socket){
		socket.on('loggin1', function(room){
			socket.join(room);
			console.log("joining Room : "+room);
			io.to(room).emit('message','A user joined room : '+room);
		});
		
		socket.on('loggin2', function(room){
			socket.join(room);
			console.log("joining Room : "+room);
			io.to(room).emit('message','A user joined room : '+room);
		});
			
	});