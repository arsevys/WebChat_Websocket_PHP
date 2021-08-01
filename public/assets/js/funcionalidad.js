
function cargarChat(datosBanner, tipo){
  document.getElementById('contenedorMensajes').innerHTML = '';
  document.getElementById('contenedorMensaje').disabled = false;
  console.log(datosBanner, tipo)
  let { nombre, id } = datosBanner;
  console.log(nombre);

  let htmlBanner = `
            <img src="https://avatar.oxro.io/avatar.svg?bold=true&name=${nombre}">
            <div class="contacto-detalle">
                <span>${nombre}</span>
                <br> <span class="texto-min-black"></span>
            </div>
            `;
            document.getElementById('banner').innerHTML = htmlBanner;
   if(tipo == 'individual') {  
    receptor = nombre;
    esGrupal = false;
    solicitarCargaDeMensajes()
   }else {
     esGrupal = true;
     idConversacionGrupal =  id;
     solicitarCargaDeMensajesGrupales();

   }  
      

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
function solicitarCargaDeMensajesGrupales(){
  if(idConversacionGrupal == null || esGrupal == false){ return;}
  console.log( ws);
  let prepareMessage = {
    accion: "listarMensajesGrupal",
    data: { emisor, idConversacion : idConversacionGrupal }
  }
  ws.send(JSON.stringify(prepareMessage));
}

function scroller(){
  getId('contenedorMensajes').scrollTop = 99999999999999999;
 }

function enviarMensaje(){
  let mensaje = getId('contenedorMensaje').value; 
  let prepareMessage = null;
  if(esGrupal){
    if(idConversacionGrupal == null  || mensaje == ''){ return;}
    
    prepareMessage = {
      accion: "registrarMensajeGrupal",
      data: { emisor, idConversacion: idConversacionGrupal, mensaje }
    }

  }else {
    if(receptor == null  || mensaje == ''){ return;}
    
    console.log(`Enviando ${mensaje} de ${emisor} a ${receptor}` );
    console.log(mensaje, ws);
    prepareMessage = {
      accion: "registrarMensajeIndividual",
      data: { emisor, receptor, mensaje }
    }
  }

  ws.send(JSON.stringify(prepareMessage));
  metodos['mensajeSaliente'](emisor, mensaje);
  getId('contenedorMensaje').value = '';

}