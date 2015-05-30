
var total = 0;
if(process.argv.length > 2){
	for(var i = 2 ; i < process.argv.length; i++){
		total+= parseInt(process.argv[i]);
	}	
	
	console.log(total);
}
