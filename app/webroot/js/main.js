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
        var counter = $(this).attr('comments-counter');
        var post_id = $(this).attr('post-id');

        if(container.hasClass('active')){
            container.removeClass('active');
            $(container).fadeOut(500);
            setTimeout(function(){
                $('#comments-from-' + post_id).remove();
                $(container).hide();
                $(container).css('height', '');
            }, 510);
            return;
        }

        container.fadeIn(500);
        container.addClass('active');

        if(counter > 0){
            $.ajax({
                url: baseurl + '/comments/post/' + encodeURIComponent($(this).attr('post-id')),
                success: function(response){
                    container.append(response);
                }
            });
        }

        $(document).ajaxStart(function(){
           $('#comments-loader-' + post_id).show();
        });

        $(document).ajaxComplete(function(){
           $('#comments-loader-' + post_id).hide();
        });
    });

    // Carousel
    $('#lazy-carousel-modal').on('show.bs.modal', function(e){
        var carousel = $(this).find('.carousel').hide();
        var deferreds = [];
        var imgs = $('.carousel', this).find('img');

        imgs.each(function(){
            var self = $(this);
            var datasrc = self.attr('item-src');

            if(datasrc) {
                var d = $.Deferred();
                self.one('load', d.resolve)
                    .attr("src", datasrc)
                    .attr('item-src', '');
                deferreds.push(d.promise());
            }
        });

        $.when.apply($, deferreds).done(function(){
            $('#carousel-loader').hide();
            carousel.fadeIn(1000);
        });
    });
});