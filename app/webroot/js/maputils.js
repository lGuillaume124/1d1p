var marker = null;

function placeMarker(coordinates, title){
    var marker = L.marker([coordinates.latitude, coordinates.longitude], {draggable: true, title: title}).addTo(map);
    map.setView([marker.getLatLng().lat, marker.getLatLng().lng], 12);
    marker.addEventListener('dragend', function(event){
        $('#latitude').val(marker.getLatLng().lat);
        $('#longitude').val(marker.getLatLng().lng);
    });
}