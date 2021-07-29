<?php 
require_once __DIR__ . "/../models/UsuarioModel.php";

require_once __DIR__ . "/../models/ConversacionModel.php";

class UsuarioController {
    public function registrar(String $username){
        // echo "\n Registrando usuario -> " . $username;
        $usuarioModel = new UsuarioModel();
        $encontrarUsuario = $usuarioModel->buscarPorNombreUsuario($username);
        print_r($encontrarUsuario);
        if(count($encontrarUsuario) == 0){
            $usuarioModel->registrar($username);
        }else {
            $usuarioModel->activarAUnUsuario($username);
        }
    }
    public function listarUsuariosConectados(){
        echo "\n Listando usuarios " ;
        $usuarioModel = new UsuarioModel();
        return $usuarioModel->listarUsuariosConectados();
    }

    public function desactivarATodosLosUsuarios(){
        echo "\n Desactivando usuarios " ;
        $usuarioModel = new UsuarioModel();
        return $usuarioModel->desactivarATodosLosUsuarios();
    }

    public function desactivarAUnUsuario(String $username){
        echo "\n Desactivando usuario " . $username ;
        $usuarioModel = new UsuarioModel();
        return $usuarioModel->desactivarAUnUsuario($username);
    }
}