
function getId(x){
    return document.getElementById(x);
}
let metodos = {
    "registrarUsuarios" : function(usuarios){
        let chatsIndividuales = getId("chats_individuales");

        for(let usuario of usuarios){
           let formato = `
            <ul onclick="cargarChat({nombre : '${usuario.nombre}'}, 'individual')" class="activo usuarios-conectados" data-usuario="${usuario.nombre}" >
                <img src="https://avatar.oxro.io/avatar.svg?bold=true&name=${usuario.nombre}">
                <div>
                    <span>${usuario.nombre}</span><br>
                    <span class="texto-min"> Estado : Activo</span>
                </div>
            </ul>`;
            chatsIndividuales.insertAdjacentHTML('beforeend', formato);
        }
    
    },
    "eliminarUsuariosDesconectados": function(usuarios){ //["arsevys"]
        let listaConectados = document.querySelectorAll('.usuarios-conectados');
        //spread
        for(let conectado of [...listaConectados]) {
            console.log(conectado.dataset);
            if(usuarios.includes(conectado.dataset.usuario)){
                conectado.remove();
            }
        }
    },
    "mensajeEntrante": function (emisor, mensaje, data){
      console.log('==>', arguments);
      if(data.tipo == 'Grupal'){ 
        if(esGrupal ==false || idConversacionGrupal != data.idConversacion){ return;}
      }
      else {
        if( esGrupal ||  receptor != data.emisor  ){ return;}
      }   

      let mensajeReceptor = `
        <div class="receptor">
            <div class="info" >
                <img src="https://avatar.oxro.io/avatar.svg?bold=true&name=${emisor}">
                <div class="mensaje">
                    <p> ${mensaje}</p>
                    <div class="text-right"><span class="contacto-nombre"> ${emisor}</span></div>
                </div>
                </div>
        </div>`;
        document.getElementById('contenedorMensajes').insertAdjacentHTML('beforeend', mensajeReceptor);
        scroller()    
    },
    "mensajeSaliente": function (emisor, mensaje){
        console.log(arguments);
  
        let mensajeEmisor= `
        <div class="emisor">
        <div class="info" >
            <img src="https://avatar.oxro.io/avatar.svg?bold=true&name=${emisor}">
            <div class="mensaje">
                <p> ${mensaje}</p>
                <div class="text-right"><span class="contacto-nombre"> ${emisor}</span></div>
            </div>
           </div>
     </div>`;
          document.getElementById('contenedorMensajes').insertAdjacentHTML('beforeend', mensajeEmisor);
          scroller()    
        },
    "cargarMensajes": function(mensajes, tipo){
            console.log(emisor);
            var self = this;
            mensajes.forEach(function(value, index){
                let data = {};
                if(tipo == 'Grupal'){ 
                    data = { idConversacion : value.id_conversacion, tipo }
                }else{
                    data = { emisor: value.nombre, tipo}
                }

                if(value.nombre == emisor){
                    self.mensajeSaliente(value.nombre, value.mensaje)
                }else {

                self.mensajeEntrante(value.nombre, value.mensaje, data)
                }
            })
      scroller()
    },
    "listarGrupos" : function(grupos){
        let chatsGrupales = getId("chats_grupales");

        for(let grupo of grupos){
           let formato = `
            <ul onclick="cargarChat({nombre : '${grupo.nombre_conversacion}', id:'${grupo.id_conversacion}'}, 'grupal')" 
            class="activo usuarios-conectados" data-usuario="${grupo.nombre_conversacion}" >
                <img src="https://avatar.oxro.io/avatar.svg?bold=true&name=${grupo.nombre_conversacion}">
                <div>
                    <span>${grupo.nombre_conversacion}</span><br>
                    <span class="texto-min"> Total Usuarios : ${grupo.cantidadUsuarios}</span>
                </div>
            </ul>`;
            chatsGrupales.insertAdjacentHTML('beforeend', formato);
        }
    
    },
}