<?php

/**
 *         $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
socket_connect($socket, '/tmp/nacRouter.sock');
socket_send($socket, json_encode($param), strlen(json_encode($param)), 0);
$response = socket_read($socket, 1024);
socket_close($socket);
 */

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$bool = socket_connect($socket, "127.0.0.1", "10001");
var_dump("socket connect:", $bool);

$param = [
    "aa" => "11",
    "bb" => "2\n2",
];
$req = json_encode($param)."\n";
//echo "send data: ".var_export($req, 1)."\n";
echo "send data:".$req."\n";
socket_send($socket, $req, strlen($req), 0);
$response = socket_read($socket, 1024);
socket_close($socket);

var_dump("socket read:", $response);
