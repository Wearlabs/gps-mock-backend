<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            html, body, #map-canvas { height: 100%; margin: 0; padding: 0;}
        </style>
    
        <script type="text/javascript" src="jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="jquery.cookie.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAa4J_mW1J6-NwvH_HtHLxVtl8JEtm3kf0"></script>
        <script type="text/javascript">
            var marker, map;

            function saveLocation(latLng, mockId) {
                $.post("save_location.php", {
                    'id': mockId,
                    'lat': latLng.lat(), 
                    'lng': latLng.lng(), 
                    'acc': '3.0' 
                });
                marker.setPosition(latLng);
            }

            function loadLocation(mockId) {
                $.get("location_mock.php?id=" + mockId, function(data) {
                    if (data) {
                        var newLatlng = new google.maps.LatLng(data.lat, data.lng);
                        marker.setPosition(newLatlng);
                        map.panTo(newLatlng);
                    }
                }, 'json');
            }

            function initialize() {
                var startLatlng = new google.maps.LatLng(-34.397, 150.644);
        
                // setup map
                map = new google.maps.Map(document.getElementById('map-canvas'), {
                    center: startLatlng,
                    zoom: 8 
                });
                google.maps.event.addListener(map, 'click', function(event) {
                    saveLocation(event.latLng, $('#mock_id').val());
                });

                // setup marker
                marker = new google.maps.Marker({
                    position: startLatlng,
                    map: map,
                    draggable: true
                });
                google.maps.event.addListener(marker, 'dragend', function(event) {
                    saveLocation(event.latLng, $('#mock_id').val());
                });

                $("#mock_form").submit(function() {
                    var mock_id = $("#mock_id").val();
                    loadLocation(mock_id);
                    $.cookie("mock_id", mock_id, { expires: 14 });
                    return false;
                });

                if ($.cookie("mock_id")) {
                    $("#mock_id").val($.cookie("mock_id"));
                }

                loadLocation($("#mock_id").val());
            }
            
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    </head>
<body>
    <div id="map-canvas"></div>
    <div id="map-overlay" style="position: fixed; bottom: 30px; right: 6px; background: white;box-shadow: 0px 0px 5px #888888;padding: 5px;">
        <form id="mock_form" method="POST" action="#set">
            Mock ID: <input id="mock_id" type="text" value="default"/>
            <input type="submit" value="SET"/>
        </form>
    </div>
</body>
</html>