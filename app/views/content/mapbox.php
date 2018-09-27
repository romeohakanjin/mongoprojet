<?php
try {
    $geoJsonArbres = "{
		  type: 'FeatureCollection',
		  features: [";

    $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $query = new MongoDB\Driver\Query([]);
    $cursor = $mng->executeQuery("ARBRES.arbrecollection", $query);
    $i=0;

    foreach($cursor as $document) {
        if ($i <= 150) {
            $longitude = $document->geometry->coordinates[0];
            $latitude = $document->geometry->coordinates[1];
            $libelle = "";
            $name = "";

            try{
                $name = $document->fields->espece;
            }catch (Exception $exception){
                $name = "Not defined";
            }

            try{
                $libelle = $document->fields->libellefrancais;
            }catch (Exception $exception){
                $libelle = "Not defined";
            }

            $geoJsonArbres = $geoJsonArbres."{
                type: 'Feature',
                geometry: {
                  type: 'Point',
                  coordinates: ['".$longitude."', '".$latitude."']
                },
                properties: {
                  title: '".$name."',
                  description: '".$libelle."'
                }
              },";
        }
        $i++;
    }

    $geoJsonArbres = $geoJsonArbres."]}";
    ?>

    <div id='map' style='width: 100%; height: 600px;'></div>

    <style>
        .marker {
            background-image: url('public/images/mapbox-icon.png');
            background-size: cover;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
        }

        .mapboxgl-popup {
            max-width: 200px;
        }

        .mapboxgl-popup-content {
            text-align: center;
            font-family: 'Open Sans', sans-serif;
        }
    </style>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoianVuemk1IiwiYSI6ImNqbWl5OW1rdzA5eGwzb2t3bnNnZ2cxZjIifQ.6U74UPVZf4ouBLUDxcxfww';

        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/dark-v9',
            center: [36, 47.8],
            zoom: 3
        });

        var geoJson = <?= $geoJsonArbres; ?>;

        // add markers to map
        geoJson.features.forEach(function(marker) {

            // create a HTML element for each feature
            var el = document.createElement('div');
            el.className = 'marker';

            // make a marker for each feature and add to the map
            new mapboxgl.Marker(el)
                .setLngLat(marker.geometry.coordinates)
                .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
                .setHTML('<h3>' + marker.properties.title + '</h3><p>' + marker.properties.description + '</p>'))
                .addTo(map);
        });

    </script>
    <?php

} catch (MongoDB\Driver\Exception\Exception $e) {
    /*$filename = basename(__FILE__);
    echo "The $filename script has experienced an error.\n";
    echo "It failed with the following exception:\n";
    echo "Exception:", $e->getMessage(), "\n";
    echo "In file:", $e->getFile(), "\n";
    echo "On line:", $e->getLine(), "\n";*/
}
?>