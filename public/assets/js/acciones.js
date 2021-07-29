
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
    "mensajeEntrante": function (emisor, mensaje){
      console.log(arguments);

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
    "cargarMensajesIndividual": function(mensajes){
      console.log(emisor);
      var self = this;
      mensajes.forEach(function(value, index){
          console.log(value);
          if(value.nombre == emisor){
                self.mensajeSaliente(value.nombre, value.mensaje)
          }else {
            self.mensajeEntrante(value.nombre, value.mensaje)
          }
      })
      scroller()
    }
}