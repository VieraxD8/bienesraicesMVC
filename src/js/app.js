document.addEventListener('DOMContentLoaded', function(){

    eventListeners();

    darkMode();

});

function eventListeners() {
   
    const mobileMenu = document.querySelector('.movile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);


    //Muesta campos condicionares

    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');

    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto));


}

function mostrarMetodosContacto(e){

    const contactoDiv = document.querySelector('#contacto');

    if(e.target.value === 'telefono'){
        contactoDiv.innerHTML = `
        <label for="telefono">Telefono</label>
        <input type="tel" placeholder="Tu telefono" id="telefono" name="contacto[telefono]">


        <p> Elija la fecha y la hor para la llamada</p>

                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" name="contacto[fecha]">

                <label for="hora">Hora:</label>
                <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]" >

        
        `;
    } else {    
        contactoDiv.innerHTML = ` 
        
        <label for="email">E-mail</label>
        <input type="email" placeholder="Tu E-mail" id="email" name="contacto[email]" required>`;
    }

}



function navegacionResponsive(){

    const navegacion = document.querySelector('.navegacion');

    if(navegacion.classList.contains('mostrar')){
        navegacion.classList.remove('mostrar');
    } else{
        navegacion.classList.add('mostrar');
    }
    
}

// colocar modo oscuro o noche la pagina

function darkMode() {

    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');

    //console.log(prefiereDarkMode.matches);

    if(prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    }else{
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkMode.addEventListener('change', function() {
        if(prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        }else{
            document.body.classList.remove('dark-mode');
        }
    });



    const botonDarkMode = document.querySelector('.dark-mode-boton');

    botonDarkMode.addEventListener('click', function() {

        document.body.classList.toggle('dark-mode');


    });
}

