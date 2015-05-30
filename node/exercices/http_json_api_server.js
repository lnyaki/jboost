var port 	= process.argv[2];
var http 	= require('http');
var url		= require('url');


var parse_time	= function(time){
	var date = new Date(time);
	return {
		'hour'		: date.getHours(),
		'minute'	: date.getMinutes(),
		'second'	: date.getSeconds()
	};
};

var unix_time	= function(time){
	var date = new Date(time).getTime();
	
	return {'unixtime': date};
};

var extract_iso = function(query){
	var data = query.split('=').pop();
	return data;
};

//var time	= extract_iso(url.search.slice(1));

var http_callback	= function(request,response){
	response.writeHead(200,{'Content-Type': 'application/json'});
	var url_data = url.parse(request.url,true);

	var raw_time = extract_iso(url_data.search.slice(1));
	var json = '';

	if(request.method == 'GET'){
		if(url_data.pathname == '/api/parsetime'){
			json = parse_time(raw_time);
		}
		else if(url_data.pathname == '/api/unixtime'){
			json = unix_time(raw_time);
		}
		else{
			console.log('Error : unknow url ['+url.pathName+']');
		}
	}
	console.log(json);
	response.end(JSON.stringify(json));
};

var server			= http.createServer(http_callback);
server.listen(port);
