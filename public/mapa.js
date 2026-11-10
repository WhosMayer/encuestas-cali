const zona = document.getElementById('zona');
const camposUrbanos = ['comuna', 'barrio'].map(id => document.getElementById(id));
const corregimiento = document.getElementById('corregimiento');
const comuna = document.getElementById('comuna');
const barrio = document.getElementById('barrio');

function actualizarBarrios() {
    for (const grupo of barrio.querySelectorAll('optgroup')) {
        grupo.disabled = grupo.hidden = grupo.dataset.comuna !== comuna.value;
    }
    if (barrio.selectedOptions[0]?.parentElement.disabled) {
        barrio.value = '';
    }
}

comuna.addEventListener('change', actualizarBarrios);
actualizarBarrios();

function actualizarZona() {
    const urbana = zona.value === 'urbana';
    for (const campo of camposUrbanos) {
        campo.disabled = !urbana;
        campo.required = urbana;
    }
    corregimiento.disabled = urbana;
    corregimiento.required = !urbana;
}

zona.addEventListener('change', actualizarZona);
actualizarZona();

const mapaEl = document.getElementById('mapa');
const latitud = document.getElementById('latitud');
const longitud = document.getElementById('longitud');

if (window.L) {
    const mapa = L.map(mapaEl).setView([3.4372, -76.5225], 12);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19,
    }).addTo(mapa);

    let marcador;
    function marcar(posicion) {
        if (!marcador) {
            marcador = L.marker(posicion, { draggable: true }).addTo(mapa);
            marcador.on('dragend', () => marcar(marcador.getLatLng()));
        } else {
            marcador.setLatLng(posicion);
        }
        latitud.value = posicion.lat.toFixed(6);
        longitud.value = posicion.lng.toFixed(6);
    }

    mapa.on('click', evento => marcar(evento.latlng));
    if (latitud.value && longitud.value &&
        Math.abs(Number(latitud.value)) <= 90 && Math.abs(Number(longitud.value)) <= 180) {
        const posicion = L.latLng(Number(latitud.value), Number(longitud.value));
        marcar(posicion);
        mapa.setView(posicion, 15);
    }
} else {
    mapaEl.textContent = 'Mapa no disponible. Puedes escribir las coordenadas.';
}
