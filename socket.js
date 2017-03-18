var server = require('http').Server();

var io = require('socket.io')(server);

var Redis = require('ioredis');

var redis = new Redis();

redis.subscribe('kiple-channel');

redis.on('message', function(channel, message){
	console.log('message reveived via '+channel);
	console.log(message);
	message = JSON.parse(message);
	// io.emit(channel + ':' + message.event, message.data);
	io.to(message.data.socketid).emit(channel + ':' + message.event, message.data);
});

var sockets = [];
global.users = {}; // just for simplicity
io.on('connection', function(socket) {
  sockets.push(socket);
  global.users.lastConnected = socket.id; // sets the user's socketId
  socket.emit('socket', socket.id); // sends a socket event over to the client
  socket.on('disconnect', function() {
    for (var key in global.users) {
      if (global.users[key] === socket.id) {
        delete global.users[key];
        break;
      }
    }
    sockets.splice(sockets.indexOf(socket), 1);
  });
});

server.listen(3000);
