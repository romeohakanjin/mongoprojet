<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="public/js/jquery.min.js"></script>
<script src="public/js/jquery.dropotron.min.js"></script>

<?php
$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

///////////////////////////////////////////////
// REQUETE POUR NOMBRE ARBRE PAR ARRONDISSEMENT
///////////////////////////////////////////////

$queryArrondissement = new MongoDB\Driver\Command([
    'aggregate' => 'arbrecollection',
    'pipeline' => [
        ['$group' => ['_id' => '$fields.arrondissement', 'nb' => ['$sum' => 1]]],
    ],
    'cursor' => new stdClass,
]);

$cursorArrondissement = $mng->executeCommand("ARBRES",  $queryArrondissement);

///////////////////////////////////////
// REQUETE POUR NOMBRE ARBRE PAR ESPECE
///////////////////////////////////////

$queryEspece = new MongoDB\Driver\Command([
    'aggregate' => 'arbrecollection',
    'pipeline' => [
        ['$group' => ['_id' => '$fields.espece', 'nb' => ['$sum' => 1]]],
    ],
    'cursor' => new stdClass,
]);

$cursorEspece = $mng->executeCommand("ARBRES",  $queryEspece);
?>

<div id="banner-wrapper">
    <div id="banner" class="box container">
        <div class="row">
            <div class="banner-div">
                <h2>Filtrer</h2>
            </div>
            <div class="search-bar">
                <div class="search-container">
                    <form method="post" action="#">
                        <select name="arrondissementSelect" id="arrondissementSelect">
                            <option value="-1" selected>Sélectionnez un arrondissement</option>
                            <?php
                            foreach($cursorArrondissement as $document) {
                                ?>
                                <option value="<?= $document->_id?>"><?= $document->_id?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <select name="especeSelect" id="especeSelect">
                            <option value="-1" selected>Selectionnez une espece</option>
                            <?php
                            foreach($cursorEspece as $document) {
                                ?>
                                <option value="<?= $document->_id?>"><?= $document->_id?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <button id="filter" type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="result">

                <?php
                if(!empty($_POST["arrondissementSelect"]) && !empty($_POST["especeSelect"])){
                    ?>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Libelle</th>
                            <th scope="col">Arrondissement</th>
                            <th scope="col">Adresse</th>
                            <th scope="col">Espece</th>
                            <th scope="col">Circonférence</th>
                            <th scope="col">Hauteur</th>
                        </tr>
                        </thead>
                        <?php
                        $arrond = $_POST["arrondissementSelect"];
                        $espece = $_POST["especeSelect"];

                        if($arrond != "-1" && $espece != "-1"){
                            $filter1 = [
                                "fields.arrondissement" => "$arrond",
                                "fields.espece" => "$espece",
                            ];
                            $query1 = new MongoDB\Driver\Query($filter1);
                            $cursor = $mng->executeQuery("ARBRES.arbrecollection", $query1);

                            foreach ($cursor as $document) {
                                if(!empty($document)){
                                    $libellefrancais =  "";
                                    $espece = "";

                                    if (!empty($document->fields->libellefrancais)) {
                                        $libellefrancais = $document->fields->libellefrancais;
                                    } else {
                                        $libellefrancais = "Not defined";
                                    }

                                    if (!empty($document->fields->espece)) {
                                        $espece = $document->fields->espece;
                                    } else {
                                        $espece = "";
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $libellefrancais ?></td>
                                        <td><?= $document->fields->arrondissement ?></td>
                                        <td><?= $document->fields->adresse ?></td>
                                        <td><?= $espece ?></td>
                                        <td><?= $document->fields->circonferenceencm ?></td>
                                        <td><?= $document->fields->hauteurenm ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        }else if($arrond != "-1" || $espece != "-1"){
                            if($espece != "-1"){
                                $filter2 = [
                                    "fields.espece" => "$espece",
                                ];
                            }

                            if($arrond != "-1"){
                                $filter2 = [
                                    "fields.arrondissement" => "$arrond",
                                ];
                            }

                            $query2 = new MongoDB\Driver\Query($filter2);
                            $cursor = $mng->executeQuery("ARBRES.arbrecollection", $query2);

                            foreach ($cursor as $document) {
                                ?>
                                <tr>
                                    <td><?= $document->fields->libellefrancais ?></td>
                                    <td><?= $document->fields->arrondissement ?></td>
                                    <td><?= $document->fields->adresse ?></td>
                                    <td><?= $document->fields->espece ?></td>
                                    <td><?= $document->fields->circonferenceencm ?></td>
                                    <td><?= $document->fields->hauteurenm ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>



