var https = require('https'),
fs = require('fs'),
io = require('socket.io'),
index;
fs.readFile('./nodejschat.html', function (err, data) {
 if (err) {
    throw err;
 }
 index = data;
});
var port = 8888;
var options = {
  key: fs.readFileSync(__dirname + '/ssl/sp2018secad.key'),
  cert: fs.readFileSync(__dirname + '/ssl/sp2018secad.crt')
};
var server = https.createServer(options, function(request, response) {
  response.writeHeader(200, {"Content-Type": "text/html"});
  response.write(index);
  response.end();
});
server.listen(port);

var socketio = io.listen(server);

console.log("chatserver is listening at port " + port);
var threadlist = [];
function getUserlist(){
	var userlist="";
	for (i = 0; i <threadlist.length; i++){
		if((threadlist[i].username!= null) && (threadlist[i].username!= 'undefined'))
			userlist += threadlist[i].username + "<br>";
	}
	return userlist;
}
function removefromUserlist(client){
	for (i = 0; i <threadlist.length; i++){
		if(threadlist[i]== client)
			threadlist.splice(i,1);
	}
}

socketio.on("connection", function (client) {
	threadlist.push(client);
	console.log("Client is connected. Userlist: " + getUserlist());
	
	client.on("<CHAT>", function(msg){
		var data = client.username + " says: " + msg;
		socketio.sockets.emit("<CHAT>", data);
		console.log("[<CHAT>," + data + "] is sent to all connected clients");
	});
	client.on("<JOIN>", function(username){
		client.username = username;
		var msg= client.username + " has joint the room";
		socketio.sockets.emit("<JOIN>", msg);
		console.log("[<JOIN>," + msg + "] is sent to all connected clients");
		socketio.sockets.emit("<URLIST>", getUserlist());
		console.log("[URLIST," + getUserlist() + "] is sent to all connected clients");
	});
	client.on("<TYPE>", function(){
		var msg= client.username + " is typing...";
		socketio.sockets.emit("<TYPING>", msg);
		console.log("[<TYPING>," + msg + "] is sent to all connected clients");
	});

	client.on("disconnect", function(){
		var msg= client.username + " has left the room";
		socketio.sockets.emit("<JOIN>", msg);
		removefromUserlist(client);
		console.log("[<JOIN>," + msg + "] is sent to all connected clients");
		socketio.sockets.emit("<URLIST>", getUserlist());
		console.log("[URLIST," + getUserlist() + "] is sent to all connected clients");
	});

});
