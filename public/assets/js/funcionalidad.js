
function cargarChat(datosBanner, tipo){
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
}