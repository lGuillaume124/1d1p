var map;
var markers = [];
var latLngs = [];
var itinerary = [];
var j = 0; // Compteur pour le tableau contenant l'itinéraire

$(document).ready(function(){
    // Génération de la carte
    map = L.map('map').setView([-37.37015, -61.98486], 5);
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 18
    }).addTo(map);
    L.control.scale().addTo(map);

    // Génération d'un rectangle sur la carte
    var bounds = L.latLngBounds([-37.37015, -61.98486]);

    // Génération des marqueurs
    for(var i = 0 ; i < posts.length ; i++){
        if(posts[i].itinerary == true){
            itinerary[j] = [posts[i].lat, posts[i].lng];
            j++;
        }

        document.getElementById(posts[i].id).id = i.toString();
        latLngs[i] = new L.latLng(posts[i].lat, posts[i].lng);
        bounds.extend(latLngs[i]);
        markers[i] = L.marker(latLngs[i], {title: posts[i].title}).addTo(map).bindPopup(posts[i].title);
    }

    // Génération de l'itinéraire
    var flightPath = L.polyline(itinerary).addTo(map);

    // Gestion de l'altitude
    map.fitBounds(bounds);

    // Print marker (on the map) on icon-marker click
    $('.icon-marker').click(function(){
        markers[this.id].openPopup();
    });

    // Display comments
    $('#timeline').on('click', '.show-comments', function(){
        var container = $('#comments-container-' + $(this).attr('post-id'));

        if(container.hasClass('active')){
            container.fadeOut(500);
            container.removeClass('active');
            $('#comments-from-' + $(this).attr('post-id')).remove();
            return;
        }

        container.fadeIn(500);
        container.addClass('active');

        $.ajax({
            url: baseurl + '/comments/post/' + encodeURIComponent($(this).attr('post-id')),
            success: function(response){
                container.append(response);
            }
        });
    });
});