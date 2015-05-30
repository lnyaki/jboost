var getTime	= function(){
	var date = new Date();
	var month = parseInt(date.getMonth())+1;
	if(month < 10){
		month = "0"+month;
	}
	
	var time = date.getFullYear();
	time += '-'+month;	
	time += '-'+((date.getDate() < 10)? '0'+date.getDate() : date.getDate());
	time += ' '+((date.getHours() < 10)? '0'+date.getHours() : date.getHours());
	time += ':'+((date.getMinutes()<10)? '0'+date.getMinutes() : date.getMinutes());
	time += '\n';
	return time; 
};
var net 	= require('net');
var server	= net.createServer(function(socket){
	socket.end(getTime());
});

server.listen(process.argv[2]);
