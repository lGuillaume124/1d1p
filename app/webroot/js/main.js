var map;
var markers = [];
var latLngs = [];

$(document).ready(function(){
    // Génération de la carte
    map = L.map('map').setView([-37.37015, -61.98486], 5);
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 18
    }).addTo(map);

    // Génération d'un rectangle sur la carte
    var bounds = L.latLngBounds([-37.37015, -61.98486]);

    // Génération des marqueurs
    for(var i = 0 ; i < posts.length ; i++){
        latLngs[i] = new L.latLng(posts[i].lat, posts[i].lng);
        bounds.extend(latLngs[i]);
        markers[i] = L.marker(latLngs[i], {title: posts[i].title}).addTo(map).bindPopup(posts[i].title);
    }
    map.fitBounds(bounds);
});