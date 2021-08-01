<?php 
require_once "Database.php";

class ConversacionModel {

    public function registrar(String $tipo){//Individual , Grupal
        $query = "INSERT into conversacion(nombre , tipo, fecha)
        values('', ?, now())";
        $conexion = (new Database())->obtenerConexion();

        $stmt = $conexion->prepare($query);
        $stmt->bindParam(1, $tipo);
        $stmt->execute();
        $id = $conexion->lastInsertId();
        return $id;
    }


    public function agregarUsuarioAUnaConversacion( int $idConversacion, int $idUsuario){
        $query = "insert into conversacionxusuarios(id_conversacion, id_usuario)
        values(?, ?)";
        $conexion = (new Database())->obtenerConexion();

        $stmt = $conexion->prepare($query);
        $stmt ->bindParam(1 , $idConversacion);
        $stmt ->bindParam(2 , $idUsuario);
        $stmt->execute();
    }
    public function validarSiExisteConversacion(Int $idUsuario1, int $idUsuario2 ){
        $query = "SELECT i.* from (
            select c.id, count(c.id) cantidad
            from conversacion c
            inner join conversacionxusuarios cu
            on c.id = cu.id_conversacion
            where tipo='Individual' and cu.id_usuario in (?,?)
            group by c.id 
        ) i
        where i.cantidad = 2
        order by i.cantidad desc limit 1";

        $conexion = (new Database())->obtenerConexion();

        $stmt = $conexion->prepare($query);
        $stmt ->bindParam(1 , $idUsuario1);
        $stmt ->bindParam(2 , $idUsuario2);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorNombreUsuario(String $username){
        $query = "select * from usuario where nombre = ?";
        $conexion = (new Database())->obtenerConexion();
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listarGrupos(int $idUsuario){
        $query = "
        SELECT t.*,
        (select count(*) from conversacionxusuarios y where y.id_conversacion=t.id_conversacion) cantidadUsuarios
         from (
        select c.nombre nombre_conversacion , cu.id_conversacion, u.id id_usuario, u.nombre from conversacion c
        inner join conversacionxusuarios cu
        on c.id = cu.id_conversacion
        inner join usuario u 
        on u.id = cu.id_usuario
        where c.tipo = 'Grupal' and cu.id_usuario = ?
        ) t";
        $conexion = (new Database())->obtenerConexion();
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(1, $idUsuario);
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

    public function listarUsuariosPorGrupo(int $idConversacion){
        $query = "select y.id_conversacion, id_usuario , u.socket_id  from conversacionxusuarios y
        inner join usuario u
        on u.id = y.id_usuario
         where y.id_conversacion=? ";
        $conexion = (new Database())->obtenerConexion();
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(1, $idConversacion);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}