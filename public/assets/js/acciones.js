
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
    }
}