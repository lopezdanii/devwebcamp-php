if(document.querySelector('#mapa')){
        var latLong= [41.648895, -4.729408];
        var zoom=15;
        var map = L.map('mapa').setView(latLong, zoom);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker(latLong).addTo(map)
        .bindPopup(`
            <h2 class="mapa__heading">DevWebCamp </h2>
            <p class="mapa__texto">Centro de Convenciones Valladolid</p>
            `)
        .openPopup();
}