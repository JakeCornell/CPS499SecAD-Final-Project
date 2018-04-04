var websocket = require('websocket.io'),
    websocketserver = websocket.listen(8000);
var clients = new Map(); 
websocketserver.on('connection', function (client) {
  client.id = client.socket.remoteAddress + ":" + client.socket.remotePort;
  //TODO:log information
  //TODO:put the client to the clients list
  client.send("Welcome client " + client.id);
  client.on('message', function (data) {
    console.log("Message from client: " + data);
    //TODO:send to all connected client
  });
  client.on('close', function () { clients.delete(client.id);});
});
