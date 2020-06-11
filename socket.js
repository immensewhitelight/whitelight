var fs = require( 'fs' );

const options = {
  key: fs.readFileSync('/home/user/conf/web/ssl.somedomain.com.key'),
  cert: fs.readFileSync('/home/user/conf/web/ssl.somedomain.com.crt')
};

const https = require('https');
const server = https.createServer(options);

var Redis = require('ioredis');
var redis = new Redis();

// Create a new Socket.io instance
var io = require('socket.io')(server);

var mysql = require('mysql');
   
redis.psubscribe('*');

redis.on('pmessage', function (pattern, channel, message) {
    message = JSON.parse(message);
    console.log(message);
    
    //console.log(message.data.data.username);
    
    // Pass data to Socket.io every time we get a new message from Redis
    // "channel + ':' + message.event" is a unique channel id to broadcast to
    //
    // message.data corresponds to the $data variable in the MessageSent event
    // in Laravel
    
    
    // messages from client are sent to laravel event to redis to socket.io
    // the socket is created when user initially loads the page 
    // at the same time the client generates username and sends it over socket.io.
    // also, at this time user ip address becomes known to socket.io.
    // through the socket connection.
    // ip address is used to block multiple connections from an ip address
    // by adding username to the participants array, and if already present, 
    // another socket connection is not allowed.
    // However, because messages from client are not sent over the socket but 
    // instead  to laravel route, they can only be blocked using laravel middleware. 
    // Thus, the client is whitelisted by ip address in mysql db 
    // on the first connection to socket.io. 
    
	io.emit(channel + ':' + message.event, message.data);
		
});

var participants = [];
var ipAddresses = [];
var username = '';
var ipAddress = '';
	
io.on('connect', function (socket) {
	
    var info = socket.handshake.headers;
	console.log(info);

	// disallow client from opening more than one connection from thier ip address
	// if user ip address is not already in the array, proceed with connect.
	if(!ipAddresses.includes(ipAddress))
	{
		// add ip to mysql db
		console.log( "ip addresses: " + ipAddresses);
		
		username = socket.handshake.query.username;
		ipAddress = socket.request.connection.remoteAddress;
		ipAddress = ipAddress.substring(7);
		
		console.log(ipAddress);
		
		// whitelist the users ip address in mysql database so it is allowed 
		// by the IPAddresses middleware
		var connection = mysql.createConnection({
			host     : 'localhost',
			user     : 'user',
			password : 'password',
			database : 'user'
			});
			
		// connect to mysql
		connection.connect(function(err) {
		// in case of error
		if(err){
			console.log(err.code);
			console.log(err.fatal);
			}
		});	
		
		// do query
		let $query = 'INSERT INTO ip_whitelist (ip_address) VALUES (?)';
		
		var result1 = connection.query(
		$query,[ ipAddress ], 
		function(err, rows, fields) {
		if(err){
			console.log("An error ocurred performing the query.");
			return;
			}
			
		});
		
		console.log("insert result1: " + result1);
		
		// Close the connection
		connection.end(function(){
		//The connection has been closed
		});		
		
		// Push the user to the array
		participants.push(username);
		ipAddresses.push(ipAddress);
		
		// The "participants" array is now included in the message
		io.emit('user-joined', { username: username, participants: participants });
				
		
		// otherwise do not proceed with connection.
		} else {
		socket.disconnect();
		// disconnected socket, to reconnect to socket
		// user must reload browser.
		// remove ipAddress from whitelist
		// thus messages cant be sent.
		// here their username is not removed
		// from the ipAddresses array in case 
		// client tries to reconnect to socket
		// without browser reload.
		
		
		 //remove ip from mysql db
        var connection3 = mysql.createConnection({
			host     : 'localhost',
			user     : 'user',
			password : 'password',
			database : 'user'
			});
			
		// connect to mysql
		connection3.connect(function(err) {
		// in case of error
		if(err){
			console.log(err.code);
			console.log(err.fatal);
			}
		});	
		
		// do query
		let $query3 = 'DELETE FROM ip_whitelist WHERE ip_address=?';
		
		var deleteResult = connection3.query(
		$query3,[ ipAddress ], 
		function(err, rows, fields) {
		if(err){
			console.log("An error ocurred performing the DELETE query.");
			return;
			}
			
		});
		
		console.log("deleted: " + deleteResult);
		
		// Close the connection
		connection3.end(function(){
		//The connection has been closed
		});	
		
		}
	
		// browser reload is still allowed to a blocked user.
		// when browser is reloaded, first there it is a disconnect.
		// here user ip address is removed from whitelist and the arrays. 
		// and the username is removed from the participants array.
		socket.on('disconnect', function (socket) {
        
        //remove ip from mysql db
        var connection2 = mysql.createConnection({
			host     : 'localhost',
			user     : 'user',
			password : 'password',
			database : 'user'
			});
			
		// connect to mysql
		connection2.connect(function(err) {
		// in case of error
		if(err){
			console.log(err.code);
			console.log(err.fatal);
			}
		});	
		
		// do query
		let $query2 = 'DELETE FROM ip_whitelist WHERE ip_address=?';
		
		var deleteResult = connection2.query(
		$query2,[ ipAddress ], 
		function(err, rows, fields) {
		if(err){
			console.log("An error ocurred performing the DELETE query.");
			return;
			}
			
		});
		
		console.log("deleted: " + deleteResult);
		
		// Close the connection
		connection2.end(function(){
		//The connection has been closed
		});	
        
        // Remove the user to the array
        participants.splice(participants.indexOf(username), 1);
        ipAddresses.splice(ipAddresses.indexOf(ipAddress), 1);

        // The "participants" array is now included in the message
        io.emit('user-left', { username: username, participants: participants });
		});
  
  });

server.listen(3000);
