var http = require("http");
var socketio = require("socket.io");
var server = http.createServer(function (request, response){
	console.log("Got a request: " + request.url);
	response.writeHead(200);
	var fs = require("fs");
	var fileStream = fs.createReadStream("./client.html");
	fileStream.pipe(response);
	response.end();
}
);
var port = 3000;
server.listen(port);
console.log("Web Server is running at port: " + port);
var websocket = socketio socketio.listen(server);
websocket.on("connection", function(client){
	console.log("A new client is connected");
	client.on("chat", function(message){
		websocket.sockets.emit("chat", message);
	});
}
);
