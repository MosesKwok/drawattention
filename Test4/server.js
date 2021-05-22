var socket = require('socket.io');
var express = require('express');
var https = require('https');
var http = require('http');
var logger = require('winston');
var fs = require('fs');


logger.remove(logger.transports.Console);
logger.add(new logger.transports.Console, { colorize: true, timestamp: true });
logger.info('SocketIO > listening on port ');

var app = express();

/*
For HTTP
var http_server = http.createServer(app).listen(3000);
*/

/*
For HTTPS
*/
var https_server = https.createServer({
    key: fs.readFileSync('moseskwok.com_3000_key.pem'),
    cert: fs.readFileSync('moseskwok.com_3000_cert.pem')
}, app).listen(3000);

function emitNewOrder(server){

    var io = socket.listen(server);
    io.sockets.on('connection',function(socket){

        socket.on("new_order",function(data){

            console.log(data);
            io.emit("new_order",data);
        });
    });

}

emitNewOrder(https_server);