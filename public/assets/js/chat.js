



window.onload= function(){
    document.getElementById('contenedorMensaje').disabled = true
    let urlAvatar = "https://avatar.oxro.io/avatar.svg?bold=true&name=";
    let user = prompt("ingrese tu usuario");
    emisor = user;
    getId("usuario_foto").src = urlAvatar+user;
    getId("usuario_nombre").innerText = user;
    ws =  new WebSocket("ws://127.0.0.1:2340/?user="+ user); 
    ws.onmessage = function(event){
        let dato = JSON.parse(event.data);
        console.log(dato);
        accion(dato.accion, dato)
    }
};

// document.getElementById('contenedorMensaje')


function accion (accion, data){
    switch(accion){
        case "usuarioConectado":
         metodos["registrarUsuarios"]([ {nombre : data.usuario}]);
        break;
        case "usuariosConectados":
        metodos["registrarUsuarios"](data.usuarios);
        break;
        case "usuarioDesconectado":
        metodos["eliminarUsuariosDesconectados"]( [data.usuario]);
        break;
        case "mensajeEntrante":
        metodos["mensajeEntrante"]( data.emisor, data.mensaje );
        break;
        case "cargarMensajesIndividual":
        metodos["cargarMensajesIndividual"]( data.mensajes);
        break;
        
    }
}