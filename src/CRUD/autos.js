document.addEventListener("DOMContentLoaded", () => {
  fetch("get_autos.php")
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById("autos-container");

      data.forEach(auto => {
        const card = document.createElement("div");
        card.classList.add("auto-card");

        card.innerHTML = `
          <img src="${auto.foto}" alt="${auto.marca} ${auto.modelo}" width="200">
          <h3>${auto.marca} ${auto.modelo} (${auto.anio})</h3>
          <p><strong>Color:</strong> ${auto.color}</p>
          <p><strong>Patente:</strong> ${auto.patente}</p>
          <p><strong>Precio:</strong> $${auto.precio}</p>
        `;

        container.appendChild(card);
      });
    })
    .catch(err => console.error("Error cargando autos:", err));
});
