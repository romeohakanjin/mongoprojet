<?php
    try {
        $customMarkersArbres = "[";

        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $query = new MongoDB\Driver\Query([]);
        $cursor = $mng->executeQuery("ARBRES.arbrecollection", $query);
        $i=1;

    foreach($cursor as $document) {
        if ($i <= 10000) {
            $longitude = $document->geometry->coordinates[0];
            $latitude = $document->geometry->coordinates[1];
            //$espece = $document->fields->espece;
            //$libellefrancais = $document->fields->libellefrancais;
            //$arbrePositions = ["", $latitude, $longitude, $i];
            //array_push($customMarkersArbres, $arbrePositions);
            $customMarkersArbres = $customMarkersArbres.'{"lat": '.$latitude.', "lng": '.$longitude.'},';
        }
        $i++;
    }
    $customMarkersArbres = $customMarkersArbres."]";
    $customMarkersArbresJson = json_encode($customMarkersArbres);
?>

<h3>Arbres</h3>

<div id="map" style="width: 100%; height: 600px;"></div>

<script>
    function initMap() {

        // initialize the map
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 5,
            center: {lat: 46.52863469527167, lng: 2.43896484375}
        });

        // Add markers to the map
        var markers = customMarkersArbresPosition.map(function(markerArbrePosition, i) {
            return new google.maps.Marker({
                position: markerArbrePosition
            });
        });

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});

        /*var geocoder = new google.maps.Geocoder();

        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 0, lng: 0},
            zoom: 8
        });

        geocoder.geocode({'address': "Paris"}, function(results, status) {
            if (status === 'OK') {
                map.setCenter(results[0].geometry.location);
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });*/
    }
    // get the markers position
    var customMarkersArbresPosition  = <?= $customMarkersArbres ?>;
</script>

<!--
load Api, async to allow the browser to render the page while the api loads, then call initMap()
-->
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAneEQ-MuKxY4xQOXUwv2gY1DIrhuHh-Jo&callback=initMap">
</script>

<?php
    } catch (MongoDB\Driver\Exception\Exception $e) {
        $filename = basename(__FILE__);
        echo "The $filename script has experienced an error.\n";
        echo "It failed with the following exception:\n";
        echo "Exception:", $e->getMessage(), "\n";
        echo "In file:", $e->getFile(), "\n";
        echo "On line:", $e->getLine(), "\n";
    }
?>