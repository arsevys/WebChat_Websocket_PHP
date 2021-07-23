window.onload= function(){
    let urlAvatar = "https://avatar.oxro.io/avatar.svg?bold=true&name=";
    let user = prompt("ingrese tu usuario");
    getId("usuario_foto").src = urlAvatar+user;
    getId("usuario_nombre").innerText = user;
    let ws =  new WebSocket("ws://127.0.0.1:2340/?user="+ user); 
    ws.onmessage = function(event){
        let dato = JSON.parse(event.data);
        console.log(dato);
        accion(dato.accion, dato)
    }
};



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
    }
}