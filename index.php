<?php
    define('ROOT', __DIR__);

    //Parametre par défaut
    if (isset($_GET['p'])) {
        $p = $_GET['p'];
    }
    else{
        $p = 'home';
    }

    //Stocker l'affichage
    ob_start();

    //Redirection en fonction du paramètre
    switch ($p) {
        case 'home':
            require ROOT.'/app/views/content/map.php';
            break;
        case 'stats':
            require ROOT.'/app/views/content/stats.php';
            break;
        default:
            //vers 404 not found http
            require ROOT.'/app/views/404.html';
            break;
    }

    $content = ob_get_clean();
    require ROOT.'/app/views/template/default.php';

?>