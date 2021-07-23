<?php

class Database {

    public function obtenerConexion(){
        $pdo =  new PDO("mysql:host=localhost:3306;dbname=ws;charset=utf8","root","");
        return $pdo;
    }
}