<?php 
require __DIR__."/../controllers/UsuarioController.php";
class Router {

    public function accion(String $accion, Array $data= array()){
    echo "\n Acccion ... \n";
      print_r(__DIR__);
      print_r($data);
      $resultado = null;
      switch ($accion){
          case "registrarUsuario":
          $user = new UsuarioController();
          $user->registrar($data["username"]);
          
          break;
          case "listarUsuariosConectados":
            $user = new UsuarioController();
            $resultado = $user->listarUsuariosConectados();
          
          break;

          case "desactivarATodosLosUsuarios":
            $user = new UsuarioController();
            $user->desactivarATodosLosUsuarios();
          break;

          case "desactivarAUnUsuario":
            $user = new UsuarioController();
            $user->desactivarAUnUsuario($data["username"]);
          break;

        default:
        echo "\n No se encontro esta accion \n";
      }

      return $resultado;
    }
}
