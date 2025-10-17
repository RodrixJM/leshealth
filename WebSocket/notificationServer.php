<?php
require __DIR__ . '/../vendor/autoload.php';

use Workerman\Worker;
use Workerman\Connection\ConnectionInterface;

// Crear un servidor WebSocket en el puerto 8080
$ws_worker = new Worker("websocket://0.0.0.0:8080");

// Almacenar conexiones
$clients = [];

// Evento al abrir conexión
$ws_worker->onConnect = function(ConnectionInterface $connection) use (&$clients) {
    $clients[$connection->id] = $connection;
    echo "🌐 Conexión abierta ({$connection->id})\n";
};

// Evento al recibir mensaje
$ws_worker->onMessage = function(ConnectionInterface $connection, $data) use (&$clients) {
    echo "Mensaje de {$connection->id}: $data\n";

    foreach ($clients as $client) {
        if ($client !== $connection) {
            $client->send("Usuario {$connection->id} dice: $data");
        }
    }
};

// Evento al cerrar conexión
$ws_worker->onClose = function(ConnectionInterface $connection) use (&$clients) {
    unset($clients[$connection->id]);
    echo "Conexión cerrada ({$connection->id})\n";
};

// Evento de error
$ws_worker->onError = function(ConnectionInterface $connection, $code, $msg) {
    echo "Error ({$connection->id}): $msg\n";
};

// Ejecutar servidor
Worker::runAll();
