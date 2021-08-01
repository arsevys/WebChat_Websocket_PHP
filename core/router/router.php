<?php 

require __DIR__."/../controllers/UsuarioController.php";
require __DIR__."/../controllers/ConversacionController.php";

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
          case "listarGrupos":
            $conv= new ConversacionController();
            $resultado = $conv->listarGrupos($data["emisor"]);
          break;
          case "listarUsuariosPorGrupo":
            $conv= new ConversacionController();
            $resultado = $conv->listarUsuariosPorGrupo($data["idConversacion"]);
          break;

          case "desactivarATodosLosUsuarios":
            $user = new UsuarioController();
            $user->desactivarATodosLosUsuarios();
          break;

          case "desactivarAUnUsuario":
            $user = new UsuarioController();
            $user->desactivarAUnUsuario($data["username"]);
          break;
          case "registrarMensajeIndividual":
            $conv= new ConversacionController();
            $resultado = $conv->registrarMensajeIndividual($data["emisor"], $data["receptor"], $data["mensaje"]);
          break;
          case "listarMensajesIndividual":
            $user = new ConversacionController();
            $resultado = $user->listarMensajesIndividual($data["emisor"], $data["receptor"]);
          break;
          case "listarMensajesGrupal":
            $user = new ConversacionController();
            $resultado = $user->listarMensajesGrupal($data["emisor"], $data["idConversacion"]);
          break;
          case "registrarMensajeGrupal":
            $conv= new ConversacionController();
            $resultado = $conv->registrarMensajeGrupal($data["emisor"], $data["idConversacion"], $data["mensaje"]);
          break;


        default:
        echo "\n No se encontro esta accion \n";
      }

      return $resultado;
    }
}
