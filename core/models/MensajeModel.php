<?php 
require_once "Database.php";

class MensajeModel {
  
    public function registrar(int $idConversacion, int $idUsuario , String $mensaje){//Individual , Grupal
        $query = "INSERT into mensaje(id_conversacion , id_usuario ,mensaje)
        values(?, ?,  ?)";
        $conexion = (new Database())->obtenerConexion();

        $stmt = $conexion->prepare($query);
        $stmt->bindParam(1, $idConversacion);
        $stmt->bindParam(2, $idUsuario);
        $stmt->bindParam(3, $mensaje);
        $stmt->execute();
        $id = $conexion->lastInsertId();
        return $id;
    }

    public function listarMensajesPorTipoConversacion(int $idConversacion, String $tipo ){//Individual , Grupal
        $query = "SELECT msj.* , u.nombre from mensaje msj
        inner join usuario u 
        on u.id = msj.id_usuario
        inner join conversacion c 
        on c.id = msj.id_conversacion
        where c.tipo = ? and c.id = ?
        order by msj.fecha asc";
        $conexion = (new Database())->obtenerConexion();

        $stmt = $conexion->prepare($query);
        $stmt->bindParam(1, $tipo );
        $stmt->bindParam(2, $idConversacion);
        $stmt->execute();
        return  $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
}