<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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

    //Create array for the graph data
    $pieChartData = [];
    $columnPieData = ['Option', 'Value'];
    array_push($pieChartData, $columnPieData);

    //Add data to array
    foreach($cursorArrondissement as $document) {
        $arrondissement = $document->_id;
        $nb = $document->nb;

        $rowPieData = [$arrondissement, $nb];

        array_push($pieChartData, $rowPieData);

    }
    $pieChartDataJson = json_encode($pieChartData);

    ////////////////////////////////////////////////
    // REQUETE POUR NOMBRE ARBRE PAR TRANCHE HAUTEUR
    ////////////////////////////////////////////////
    ini_set('memory_limit', '-1');

    // Entre 0 et 5
    $filter1 = [
        "fields.hauteurenm" => ['$gt' => 0, '$lt' => 5],
    ];
    $query1 = new MongoDB\Driver\Query($filter1);
    $cursor = $mng->executeQuery("ARBRES.arbrecollection", $query1);
    $tranche1 = count($cursor->toArray());

    //Entre 5 et 10
    $filter2 = [
        "fields.hauteurenm" => ['$gt' => 5, '$lt' => 10],
    ];
    $query2 = new MongoDB\Driver\Query($filter2);
    $cursor = $mng->executeQuery("ARBRES.arbrecollection", $query2);
    $tranche2 = count($cursor->toArray());

    //Entre 10 et 25
    $filter3 = [
        "fields.hauteurenm" => ['$gt' => 10, '$lt' => 20],
    ];
    $query3 = new MongoDB\Driver\Query($filter3);
    $cursor = $mng->executeQuery("ARBRES.arbrecollection", $query3);
    $tranche3 = count($cursor->toArray());

    //Entre 25 et 40
    $filter4 = [
        "fields.hauteurenm" => ['$gt' => 20, '$lt' => 40],
    ];
    $query4 = new MongoDB\Driver\Query($filter4);
    $cursor = $mng->executeQuery("ARBRES.arbrecollection", $query4);
    $tranche4 = count($cursor->toArray());

    //Supérieur à 40
    $filter5 = [
        "fields.hauteurenm" => ['$gt' => 40],
    ];
    $query5 = new MongoDB\Driver\Query($filter5);
    $cursor = $mng->executeQuery("ARBRES.arbrecollection", $query5);
    $tranche5 = count($cursor->toArray());

    $columnChartData = [];
    $columnData = ['Tranche', 'Nombres'];
    array_push($columnChartData, $columnData);
    array_push($columnChartData, ['0-5', $tranche1]);
    array_push($columnChartData, ['5-10', $tranche2]);
    array_push($columnChartData, ['10-25', $tranche3]);
    array_push($columnChartData, ['25-40', $tranche4]);
    array_push($columnChartData, ['>40', $tranche5]);
    $columnChartDataJson = json_encode($columnChartData);

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

    //Create array for the graph data
    $donutChartData = [];
    $columnDonutData = ['Option', 'Value'];
    array_push($donutChartData, $columnDonutData);

    //Add data to array
    foreach($cursorEspece as $document) {
        $espece = $document->_id;
        $nb = $document->nb;

        $rowDonutData = [$espece, $nb];

        array_push($donutChartData, $rowDonutData);

    }
    $donutChartDataJson = json_encode($donutChartData);
?>

<script>
    google.charts.load('current', {'packages':['corechart']});
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawPieChart);
    google.charts.setOnLoadCallback(drawColumnChart);
    google.charts.setOnLoadCallback(drawDonutChart);

    function drawPieChart() {
        var dataJson = <?= $pieChartDataJson ?>;

        // Create the data table.
        var data = new google.visualization.arrayToDataTable(
            dataJson
        );
        // Set chart options
        var options = {'title':'Nombre d\'arbre par arrondissement',
            'width':600,
            'height':500};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }

    function drawColumnChart() {
        var dataJson = <?= $columnChartDataJson ?>;
        var data = google.visualization.arrayToDataTable(
            dataJson
        );

        var view = new google.visualization.DataView(data);

        var options = {
            title: "Nombre d\'arbre par tranche de hauteur",
            width: 400,
            height: 400,
            bar: {groupWidth: "95%"},
            legend: { position: "none" },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
    }

    function drawDonutChart() {
        var dataJson = <?= $donutChartDataJson ?>;

        // Create the data table.
        var data = new google.visualization.arrayToDataTable(
            dataJson
        );
        // Set chart options
        var options = {'title':'Nombre d\'arbre par espèce',
            'width':600,
            'height':500,
            pieHole: 0.4
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    }
</script>
<div id="chart_div"></div>
<div id="columnchart_values" style="width: 900px; height: 300px;"></div>
<div id="donutchart" style="width: 900px; height: 500px;"></div>