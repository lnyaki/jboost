var path = process.argv[2];
var fs = require('fs');

var buff = fs.readFileSync(path);

var content = buff.toString(); 

var lines = content.split('\n');


console.log(lines.length-1);
