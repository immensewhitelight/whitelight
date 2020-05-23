var fs = require( 'fs' );
const https = require('https');

const options = {
  key: fs.readFileSync('/home/user/conf/web/ssl.domain.com.key'),
  cert: fs.readFileSync('/home/user/conf/web/ssl.domain.com.crt')
};
const server = https.createServer(options);
const io = require('socket.io')(server);
//server.listen(443);

var Redis = require('ioredis');
var redis = new Redis();

redis.psubscribe('*');

redis.on('pmessage', function (pattern, channel, message) {
    message = JSON.parse(message);
    
    console.log(message);

    // Pass data to Socket.io every time we get a new message from Redis
    // "channel + ':' + message.event" is a unique channel id to broadcast to
    //
    // message.data corresponds to the $data variable in the MessageSent event
    // in Laravel
    io.emit(channel + ':' + message.event, message.data);
    
});


var participants = [];

io.on('connect', function (socket) {
    var username = socket.handshake.query.username;
    
    // beginnging of returning ip addresses as user names
    var info = socket.handshake.headers;
	console.log(info);
	
    // Push the user to the array
    participants.push(username);

    // The "participants" array is now included in the message
    io.emit('user-joined', { username: username, participants: participants });

    socket.on('disconnect', function (socket) {
        // Remove the user to the array
        participants.splice(participants.indexOf(username), 1);

        // The "participants" array is now included in the message
        io.emit('user-left', { username: username, participants: participants });
    });
});

server.listen(3000);
