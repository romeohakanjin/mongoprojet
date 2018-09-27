<?php
    try {
        $customMarkersArbres = [];

        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $query = new MongoDB\Driver\Query([]);
        $cursor = $mng->executeQuery("ARBRES.arbrecollection", $query);
        $i=1;

    foreach($cursor as $document) {
        if ($i != 1){
            //$geoJsonArbres = $geoJsonArbres.",";
        }
        if ($i <= 15000) {
            $longitude = $document->geometry->coordinates[0];
            $latitude = $document->geometry->coordinates[1];
            //$libellefrancais = $document->fields->libellefrancais;
            //echo $name." = longitude: ".$longitude." ---- latitude: ".$latitude."<br/>";
            $arbrePositions = ["", $latitude, $longitude, $i];
            array_push($customMarkersArbres, $arbrePositions);
        }
        $i++;
    }
    $customMarkersArbresJson = json_encode($customMarkersArbres);
?>

<h3>Arbres</h3>
<!--The div element for the map -->
<div id="map" style="width: 100%; height: 600px;"></div>

<script>
    // Markers arbres position
    var customMarkersArbres = <?= $customMarkersArbresJson ?>;

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: {lat:  76.52863469527167, lng: 2.43896484375}
        });

        setMarkers(map);
    }

    function setMarkers(map) {
        // Adds markers to the map.

        // Marker sizes are expressed as a Size of X,Y where the origin of the image
        // (0,0) is located in the top left of the image.

        // Origins, anchor positions and coordinates of the marker increase in the X
        // direction to the right and in the Y direction down.
        var image = {
            url: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
            // This marker is 20 pixels wide by 32 pixels high.
            size: new google.maps.Size(20, 32),
            // The origin for this image is (0, 0).
            origin: new google.maps.Point(0, 0),
            // The anchor for this image is the base of the flagpole at (0, 32).
            anchor: new google.maps.Point(0, 32)
        };
        // Shapes define the clickable region of the icon. The type defines an HTML
        // <area> element 'poly' which traces out a polygon as a series of X,Y points.
        // The final coordinate closes the poly by connecting to the first coordinate.
        var shape = {
            coords: [1, 1, 1, 20, 18, 20, 18, 1],
            type: 'poly'
        };
        for (var i = 0; i < customMarkersArbres.length; i++) {
            var arbre = customMarkersArbres[i];
            var marker = new google.maps.Marker({
                position: {lat: arbre[1], lng: arbre[2]},
                map: map,
                icon: image,
                shape: shape,
                title: arbre[0],
                zIndex: arbre[3]
            });
        }

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': "Paris"}, function(results, status) {
            if (status === 'OK') {
                map.setCenter(results[0].geometry.location);
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }
</script>
<!--Load the API from the specified URL
* The async attribute allows the browser to render the page while the API loads
* The key parameter will contain your own API key (which is not needed for this tutorial)
* The callback parameter executes the initMap() function
-->
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqv6FYA0t_kJEMwTVrz7us77Qjd5CIgXs&callback=initMap">
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