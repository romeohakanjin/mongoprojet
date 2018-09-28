<?php
    define('ROOT', __DIR__);

    // Default parameters
    if (isset($_GET['p'])) {
        $p = $_GET['p'];
    }
    else{
        $p = 'map';
    }

    // Keep the page display
    ob_start();

    // Redirection
    switch ($p) {
        case 'map':
            require ROOT.'/app/views/content/map.php';
            break;
        case 'mapbox':
            require ROOT.'/app/views/content/mapBox.php';
            break;
        case 'stats':
            require ROOT.'/app/views/content/stats.php';
            break;
        case 'recherche':
            require ROOT.'/app/views/content/recherche.php';
            break;
        default:
            //vers 404 not found http
            require ROOT.'/app/views/404.php';
            break;
    }

    $content = ob_get_clean();
    require ROOT.'/app/views/template/default.php';

?>