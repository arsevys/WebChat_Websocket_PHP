<?php 
require_once "Database.php";

class UsuarioModel {

    public function registrar(String $username){
        $query = "INSERT into usuario(nombre, socket_id, estado) 
        values(? , ? , 'Activo')";
        $conexion = (new Database())->obtenerConexion();

        $stmt = $conexion->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $username);
        $stmt->execute();
    }

    public function desactivarATodosLosUsuarios(){
        $query = "update usuario set estado='Inactivo' ";
        $conexion = (new Database())->obtenerConexion();

        $stmt = $conexion->prepare($query);
        $stmt->execute();
    }

    public function desactivarAUnUsuario(String $username){
        $query = "update usuario set estado='Inactivo' where nombre = ? ";
        $conexion = (new Database())->obtenerConexion();

        $stmt = $conexion->prepare($query);
        $stmt ->bindParam(1 , $username);
        $stmt->execute();
    }
    public function activarAUnUsuario(String $username){
        $query = "update usuario set estado='Activo' where nombre = ? ";
        $conexion = (new Database())->obtenerConexion();

        $stmt = $conexion->prepare($query);
        $stmt ->bindParam(1 , $username);
        $stmt->execute();
    }

    public function buscarPorNombreUsuario(String $username){
        $query = "select * from usuario where nombre = ?";
        $conexion = (new Database())->obtenerConexion();
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarUsuariosConectados(){
        $query = "select * from usuario where estado = 'Activo'";
        $conexion = (new Database())->obtenerConexion();
        $stmt = $conexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}