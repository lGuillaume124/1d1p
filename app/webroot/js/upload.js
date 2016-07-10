var marker = null;

$(document).ready(function() {

    $('#PostFile').on('change', function() {

        $('#map').css('min-height', '305px');
        $('#upload-progress').fadeIn(500);

        var xhr = new XMLHttpRequest();

        xhr.open('POST', '/posts/upload');

        xhr.onload = function() {

            var response = JSON.parse(xhr.responseText);

            if (response.error != null) {
                $('#upload-progress-bar').addClass('progress-bar-danger');
                alert(response.error);
            }

            if (response.photo != null) {

                $('#upload-progress-bar').addClass('progress-bar-success');
                $('#upload-progress').delay(1500).fadeOut(1000);
                $('#map').delay(3000).queue(function(next){
                    $(this).css('min-height', '345px');
                    next();
                });
                $('#PostPostDt').val(response.datetime_original);
                $('#PostOriginalName').val(response.original_name);

                if (response.coordinates != null) {

                    $('#latitude').val(response.coordinates.lat);
                    $('#longitude').val(response.coordinates.lng);

                    // On génère un marqueur avec les ccordonnés de la photo et on centre la carte sur le marqueur
                    marker = L.marker(response.coordinates, {draggable: true, title: response.photo}).addTo(map);
                    map.setView(marker.getLatLng(), 12);

                } else {

                    // On génère un marqueur au centre de la carte
                    marker = L.marker(map.getCenter(), {draggable: true, title: response.photo}).addTo(map);
                    $('#latitude').val(marker.getLatLng().lat);
                    $('#longitude').val(marker.getLatLng().lng);
                    navigator.geolocation.getCurrentPosition(function(position){
                        $('#latitude').val(position.coords.latitude);
                        $('#longitude').val(position.coords.longitude);

                        // On met à jour le marqueur, on zoom et on le centre
                        marker.setLatLng([position.coords.latitude, position.coords.longitude]);
                        map.setView(marker.getLatLng(), 12);
                    }, function(error) {
                        console.log(error);
                    });

                }

                marker.addEventListener('dragend', function() {
                    $('#latitude').val(marker.getLatLng().lat);
                    $('#longitude').val(marker.getLatLng().lng);
                });

                $('#PostPicture').val(response.photo);

                // Mise à jour de la carte si mise à jour des champs GPS
                $('#latitude').on('blur', function() {
                    coordinates = L.latLng($('#latitude').val(), $('#longitude').val());
                    marker.setLatLng(coordinates);
                    map.setView(coordinates);
                });

                $('#longitude').on('blur', function() {
                    coordinates = L.latLng($('#latitude').val(), $('#longitude').val());
                    marker.setLatLng(coordinates);
                    map.setView(coordinates);
                });

            } else {
                $('#upload-progress-bar').addClass('progress-bar-danger');
            }
        };

        xhr.upload.onprogress = function(e) {
            $('#upload-progress-bar').css('width', (e.loaded/e.total)*100+"%");
        };

        var form = new FormData();

        form.append('data[Post][file]', $(this)[0].files[0]);
        xhr.send(form);
    });

    $('#AddPostForm').submit(function() {
        $('#PostFile').remove();
    });
});

