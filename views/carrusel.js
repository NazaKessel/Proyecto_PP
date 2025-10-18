document.addEventListener('DOMContentLoaded', () => {
    // 1. Obtener los elementos del DOM
    const carruselContenedor = document.querySelector('.carrusel-contenedor');
    const prevBtn = document.querySelector('.carrusel-btn.prev');
    const nextBtn = document.querySelector('.carrusel-btn.next');

    // 2. Definir el desplazamiento
    // Se recomienda calcular el ancho de una tarjeta + el espacio entre ellas (gap)
    // Usaremos un valor fijo basado en el CSS: 250px (ancho tarjeta) + 15px (gap) = 265px
    const desplazamiento = 265; 

    // Opcional: para un desplazamiento por 'página' de tarjetas visibles
    // const desplazamientoPorContenedor = carruselContenedor.clientWidth; 


    // 3. Función para el botón 'Anterior'
    prevBtn.addEventListener('click', () => {
        // scrollLeft es la posición de scroll horizontal actual
        carruselContenedor.scrollLeft -= desplazamiento;
    });

    // 4. Función para el botón 'Siguiente'
    nextBtn.addEventListener('click', () => {
        carruselContenedor.scrollLeft += desplazamiento;
    });

});
