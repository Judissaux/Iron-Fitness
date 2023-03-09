let map = document.getElementById('map');

 map = L.map('map').setView([50.429502473032684, 2.788923834219555], 13);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 21,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var circle = L.circle([50.42809598997900, 2.789102153839100], {
    color: 'red',
    fillColor: '#f03',
    fillOpacity: 0.5,
    radius: 25
}).addTo(map);

var popup = L.popup()
    .setLatLng([50.42809598997900, 2.789102153839100])
    .setContent("Iron Fitness")
    .openOn(map);
