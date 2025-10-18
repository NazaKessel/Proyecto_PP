document.addEventListener('DOMContentLoaded', () => {
    // Seleccionamos solo el carrusel de promociones
    const promoCarrusel = document.querySelector('.promo');
    if (!promoCarrusel) return; // Si no hay carrusel de promociones, no hacer nada

    const carruselContenedor = promoCarrusel.querySelector('.promo-contenedor');
    const prevBtn = promoCarrusel.querySelector('.btn-promo.prev');
    const nextBtn = promoCarrusel.querySelector('.btn-promo.next');

    // Desplazamiento: una tarjeta completa (100% del contenedor)
    const desplazamiento = carruselContenedor.clientWidth;

    // Botón 'Anterior'
    prevBtn.addEventListener('click', () => {
        carruselContenedor.scrollLeft -= desplazamiento;
    });

    // Botón 'Siguiente'
    nextBtn.addEventListener('click', () => {
        carruselContenedor.scrollLeft += desplazamiento;
    });
});
