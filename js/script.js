document.addEventListener("DOMContentLoaded", function() {
    const botonCambiarColor = document.getElementById("cambiarColor");
    const botonMostrarMensaje = document.getElementById("MostrarMensaje");
    const mensajeElement = document.getElementById("mensaje");
    const formulario = document.querySelector("form");

    function generarColorAleatorio() {
        const letras = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letras[Math.floor(Math.random() * 16)];
    }
    return color;
}
// cambiar el color de fondo al hacer clic en el botón
botonCambiarColor.addEventListener("click", function() {
    document.body.style.backgroundColor = generarColorAleatorio();
})

// Mostrar y ocultar el mensaje al hacer clic en el botón
// al hacer clic en el botón, se muestra u oculta el mensaje
// y se cambia el texto del botón
botonMostrarMensaje.addEventListener("click", function() {
   if (mensajeElement.classList.contains("oculto")) {
       mensajeElement.classList.remove("oculto");
       botonMostrarMensaje.textContent = "Ocultar Mensaje";
   }else {
    mensajeElement.classList.add("oculto");
    botonMostrarMensaje.textContent = "Mostrar Mensaje";
   }
})

formulario.addEventListener("submit", function(event) {
    event.preventDefault(); // Evita el envío del formulario

    const nombre = document.getElementById("nombre").value;
    const email = document.getElementById("correo").value;
    const mensaje = document.getElementById("mensajeContacto").value;

    //Mostrar mensaje de confirmación
    alert(`Gracias por tu mensaje, ${nombre}! Hemos recibido tu correo electrónico: ${email} y tu mensaje: "${mensaje}". Te contactaremos pronto.`);
    // Limpiar el formulario
    formulario.reset();
});


})