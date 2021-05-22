<?php 

set_time_limit(0); 
$host = "127.0.0.1"; 
$port = 3000; 
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)or die("Could not create socket\n"); // 建立一個Socket 
$connection = socket_connect($socket, $host, $port) or die("Could not connet server\n"); // 連線 
socket_write($socket, "hello socket") or die("Write failed\n"); // 資料傳送 向伺服器傳送訊息 
while ($buff = socket_read($socket, 1024, PHP_NORMAL_READ)) { 
    echo("Response was:" . $buff . "\n");
} 
socket_close($socket); 

?>

<html>
    <head>
        <title>DrawAttention互動遊戲-首頁</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"/>
        
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.js"></script>
        
        
        
    </head>
    <body>
    </body>
</html>