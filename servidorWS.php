<?php

require __DIR__."/vendor/autoload.php";
use Workerman\Worker;
require __DIR__."/core/router/router.php";

$worker = new Worker("websocket://0.0.0.0:2340");

$worker->name = "Mi Servidor Websocket";
$worker->count = 1;
$router = new Router();

//Desactivar a todos los usuarios antes de empezar 
$router->accion('desactivarATodosLosUsuarios');

//Aca llegaran cada cliente conectado
$worker->onConnect=function($connection) use (&$router,&$worker){
    echo "\n Un Cliente Nuevo se conecto !!!\n\n";
    $user = "";
    $connection->onWebSocketConnect = function($socket) use(&$user, &$connection, &$router,&$worker){
        echo "\n Usuario : " . $_GET["user"] ."\n";
        $user = $_GET["user"];
        echo $socket->id;
        $connection->id = $_GET["user"];

         //Enviarle todos los usuarios actualmente conectados
         $listaUsuariosConectados=  $router->accion("listarUsuariosConectados", array());
         echo "USuarios Conectados : \n";
         print_r($listaUsuariosConectados);

        //Posible Registro del Usuario
        $router->accion("registrarUsuario", array("username"=>$user));
        //Notificamos alos demas usuario 
        enviarAUsuarios($worker,$user, array("accion"=>"usuarioConectado", "usuario"=>$user));
        enviarAUsuario($connection, array("accion"=>"usuariosConectados", "usuarios"=> $listaUsuariosConectados ));
        };
};


//Aca llegaran los mensajes de cada cliente conectado
$worker->onMessage=function($connection, $data) use (&$worker, &$user){
    echo "\n Mensaje:".$data."\n\n";
    //Individual
    // $connection->send("Tu Mensaje fue : ". $data );
    // print_r($worker->connections);
    foreach($worker->connections as $connect){
        $connect->send($connection->id ." : ". $data);
    }
};

$worker->onClose = function($connection)use(&$router, &$worker){
    echo "\n Usuario Desconectado : ". $connection->id . "\n";
    $router->accion("desactivarAUnUsuario", array( "username" => $connection->id));

    enviarAUsuarios($worker,$connection->id , array("accion"=>"usuarioDesconectado", "usuario"=>$connection->id ));
};


//Cuando un worker se acaba de ejecutar correctamente
$worker->onWorkerStart= function($worker){
    echo "\n Servidor Websocket Ejecutando en el puerto 2340!!!\n";
};


function enviarAUsuarios($worker,$usuarioEmisor, $data){
    foreach($worker->connections as $connect){
        if($connect->id != $usuarioEmisor){
            $connect->send(json_encode($data));
        }
    }
}

function enviarAUsuario($connection, $data){
    $connection->send(json_encode($data));
}

//Ejecuta todos los workers
Worker::runAll();