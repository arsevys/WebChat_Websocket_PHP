<?php
require_once __DIR__ . "/../models/UsuarioModel.php";
require_once __DIR__ . "/../models/ConversacionModel.php";
require_once __DIR__ . "/../models/MensajeModel.php";
class ConversacionController  {

    public function registrarMensajeIndividual(String $emisor , String $receptor , String $msj){
        $resultado = false;
        //Validacion si existe una conversacion entre 2 usuarios
        $usuario = new UsuarioModel();
        $idUsuario1  =  $usuario->buscarPorNombreUsuario($emisor);
        $idUsuario2  =  $usuario->buscarPorNombreUsuario($receptor);

        if(count($idUsuario1) == 0 || count($idUsuario2) == 0) {
          return $resultado;
        }

        $idUsuario1 = $idUsuario1[0]['id'];
        $idUsuario2 = $idUsuario2[0]['id'];
        echo "Emisor ID : " . $idUsuario1 . "\n";
        echo "Receptor ID : " . $idUsuario2 . "\n";

        $conversacion = new ConversacionModel();
        $mensaje = new MensajeModel();
        $validar = $conversacion->validarSiExisteConversacion($idUsuario1, $idUsuario2);
        print_r($validar);
        if(count($validar)== 0){
          
          $idConversacion = $conversacion->registrar('Individual');
          echo "Id Conversacion : " . $idConversacion. "\n";
          $conversacion->agregarUsuarioAUnaConversacion($idConversacion, $idUsuario1);
          $conversacion->agregarUsuarioAUnaConversacion($idConversacion, $idUsuario2);
          $mensaje->registrar($idConversacion,$idUsuario1, $msj );
          $resultado = true;
        }else {
          $idConversacion = $validar[0]['id'];
          $mensaje->registrar($idConversacion,$idUsuario1, $msj );
          $resultado = true;
        }

        return $resultado;
    }
    public function listarMensajesIndividual(String $emisor , String $receptor){
      $resultado = array();
      //Validacion si existe una conversacion entre 2 usuarios
      $usuario = new UsuarioModel();
      $idUsuario1  =  $usuario->buscarPorNombreUsuario($emisor);
      $idUsuario2  =  $usuario->buscarPorNombreUsuario($receptor);

      if(count($idUsuario1) == 0 || count($idUsuario2) == 0) {
        return $resultado;
      }

      $idUsuario1 = $idUsuario1[0]['id'];
      $idUsuario2 = $idUsuario2[0]['id'];
      echo "Emisor ID : " . $idUsuario1 . "\n";
      echo "Receptor ID : " . $idUsuario2 . "\n";

      $conversacion = new ConversacionModel();
      $mensaje = new MensajeModel();
      $validar = $conversacion->validarSiExisteConversacion($idUsuario1, $idUsuario2);
      print_r($validar);
      if(count($validar)> 0){
        
        $idConversacion = $validar[0]['id'];
        $resultado  = $mensaje->listarMensajesPorTipoConversacion($idConversacion,'Individual');
        
      }

      return $resultado;
    }
    public function listarMensajesGrupal(String $emisor , int $idConversacion){
      $resultado = array();
      //Validacion si existe una conversacion entre 2 usuarios
      $usuario = new UsuarioModel();
      $idUsuario1  =  $usuario->buscarPorNombreUsuario($emisor);

      if(count($idUsuario1) == 0) {
        return $resultado;
      }

      $idUsuario1 = $idUsuario1[0]['id'];
      echo "Emisor ID : " . $idUsuario1 . "\n";


      $mensaje = new MensajeModel();

      $resultado  = $mensaje->listarMensajesPorTipoConversacion($idConversacion,'Grupal');

      return $resultado;
    }
    public function listarGrupos(String $emisor ){
      $resultado = array();
      //Validacion si existe una conversacion entre 2 usuarios
      $usuario = new UsuarioModel();
      $idUsuario1  =  $usuario->buscarPorNombreUsuario($emisor);

      if(count($idUsuario1) == 0) {
        return $resultado;
      }

      $idUsuario1 = $idUsuario1[0]['id'];
      echo "Emisor ID : " . $idUsuario1 . "\n";



      $conversacion = new ConversacionModel();
      $resultado = $conversacion->listarGrupos($idUsuario1);
      return $resultado;
    }
    public function registrarMensajeGrupal(String $emisor ,int $idConversacion , String $msj){
      $resultado = false;
      //Validacion si existe una conversacion entre 2 usuarios
      $usuario = new UsuarioModel();
      $idUsuario1  =  $usuario->buscarPorNombreUsuario($emisor);

      if(count($idUsuario1) == 0 ) {
        return $resultado;
      }

      $idUsuario1 = $idUsuario1[0]['id'];
      echo "Emisor ID : " . $idUsuario1 . "\n";
      $mensaje = new MensajeModel();
      $mensaje->registrar($idConversacion,$idUsuario1, $msj );
      $resultado = true;

      return $resultado;
    }
    public function listarUsuariosPorGrupo(int $idConversacion){
      $resultado = array();
      //Validacion si existe una conversacion entre 2 usuarios

      $conversacion = new ConversacionModel();
      $resultado = $conversacion->listarUsuariosPorGrupo($idConversacion);
      return $resultado;
    }
}  

