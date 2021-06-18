<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
//
//require __DIR__ . '/../src/Client.php';
//
//$clients = [];
//$testClients = 30;
//$testMessages = 500;
//for ($i = 0; $i < $testClients; $i++) {
//    $clients[$i] = new \Bloatless\WebSocket\Client;
//    $clients[$i]->connect('127.0.0.1', 8000, '/demo', 'foo.lh');
//}
//usleep(5000);
//
//$payload = json_encode([
//    'action' => 'echo',
//    'data' => 'dos',
//]);
//
//for ($i = 0; $i < $testMessages; $i++) {
//    $clientId = rand(0, $testClients-1);
//    $clients[$clientId]->sendData($payload);
//    usleep(5000);
//}
//usleep(5000);
require __DIR__ . '/../src/Client.php';
$client = new \Bloatless\WebSocket\Client;

$client->connect('127.0.0.1', 8000, '/demo');
$client->sendData(json_encode([
            'action' => 'echo',
            'data' => 'Websockets']
    )
);

$client->connect('127.0.0.1', 8000, '/demo');
$client->sendData(json_encode([
            'action' => 'echo',
            'data' => '{"id":0, "message":"hidden Text"}']
    )
);

$client->sendData(json_encode([
            'action' => 'echo',
            'data' => '{"id":1, "message":"Websockets mit Vue"}']
    )
);
