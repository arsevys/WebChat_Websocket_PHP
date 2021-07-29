
function cargarChat(datosBanner, tipo){
  document.getElementById('contenedorMensajes').innerHTML = '';
  document.getElementById('contenedorMensaje').disabled = false;
  console.log(datosBanner, tipo)
  let { nombre } = datosBanner;
  console.log(nombre);
  let htmlBanner = `
            <img src="https://avatar.oxro.io/avatar.svg?bold=true&name=${nombre}">
            <div class="contacto-detalle">
                <span>${nombre}</span>
                <br> <span class="texto-min-black"></span>
            </div>
            `;
            document.getElementById('banner').innerHTML = htmlBanner;
      receptor = nombre;

      solicitarCargaDeMensajes()
}

getId('contenedorMensaje').addEventListener('keydown',function(e){
  // console.log(e);
  if(e.key == 'Enter'){
    enviarMensaje();
  }
});

function solicitarCargaDeMensajes(){
  if(receptor == null){ return;}
  console.log( ws);
  let prepareMessage = {
    accion: "listarMensajesIndividual",
    data: { emisor, receptor }
  }
  ws.send(JSON.stringify(prepareMessage));
}
function scroller(){
  getId('contenedorMensajes').scrollTop = 99999999999999999;
}

function enviarMensaje(){
  let mensaje = getId('contenedorMensaje').value; 
  if(receptor == null  || mensaje == ''){ return;}
    
    console.log(`Enviando ${mensaje} de ${emisor} a ${receptor}` );
    console.log(mensaje, ws);
    let prepareMessage = {
      accion: "registrarMensajeIndividual",
      data: { emisor, receptor, mensaje }
    }
    ws.send(JSON.stringify(prepareMessage));
    metodos['mensajeSaliente'](emisor, mensaje);
    getId('contenedorMensaje').value = '';
}