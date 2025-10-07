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

    // Opcional: Funcionalidad de auto-ocultar botones si ya no hay más scroll
    // (Esto es más complejo y no se requiere inicialmente, pero mejora la UX)
    /*
    const verificarBotones = () => {
        const { scrollLeft, scrollWidth, clientWidth } = carruselContenedor;
        
        // Botón 'Anterior' se oculta al inicio
        prevBtn.style.display = scrollLeft > 0 ? 'flex' : 'none'; 
        
        // Botón 'Siguiente' se oculta al final. Un pequeño margen es útil.
        const estaAlFinal = scrollLeft + clientWidth >= scrollWidth - 5;
        nextBtn.style.display = estaAlFinal ? 'none' : 'flex';
    };

    carruselContenedor.addEventListener('scroll', verificarBotones);
    window.addEventListener('resize', verificarBotones); // En caso de cambio de tamaño de ventana
    verificarBotones(); // Ejecutar al cargar para establecer el estado inicial
    */
});