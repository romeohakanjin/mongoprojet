<?php
    try {
        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

        $query = new MongoDB\Driver\Query([]);

        /* Interrogez la collection  "asteroids" de la base de données "test" */
        $cursor = $mng->executeQuery("ARBRES.arbrecollection", $query);

        foreach($cursor as $document) {
            $longitude = $document->geometry->coordinates[0];
            $latitude = $document->geometry->coordinates[1];
            //$name = $document->fields->espece;
            //echo $name." = longitude: ".$longitude." ---- latitude: ".$latitude."<br/>";
            echo "longitude: ".$longitude." ---- latitude: ".$latitude."<br/>";
        }
    } catch (MongoDB\Driver\Exception\Exception $e) {

        $filename = basename(__FILE__);

        echo "The $filename script has experienced an error.\n";
        echo "It failed with the following exception:\n";

        echo "Exception:", $e->getMessage(), "\n";
        echo "In file:", $e->getFile(), "\n";
        echo "On line:", $e->getLine(), "\n";
    }

?>