var http = require("http");
var server = http.createServer(function (request, response){
	console.log("Got a request: " + request.url);
	response.write("Hello from sp2018secad");
	response.end();
}
);
var port = 3000;
server.listen(port);
console.log("Web Server is running at port: " + port);
