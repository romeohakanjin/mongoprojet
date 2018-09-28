<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta name="description" content="rh-sl-fc-jx">
    <meta name="author" content="rh-sl-jx">

    <title>Mongo Project</title>
    <meta equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="public/css/main.css" />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.46.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.46.0/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/style.css" />
</head>

<body class="homepage">
<div id="page-wrapper">
    <div id="header-wrapper">
        <header id="header" class="container">
            <div id="logo">
                <h1>
                    MongoProject
                </h1>
            </div>
            <nav id="nav">
                <ul>
                    <li id="mappage"><a href="index.php?p=map">Map</a></li>
                    <li id="mapbox"><a href="index.php?p=mapbox">MapBox</a></li>
                    <li id="statspage"><a href="index.php?p=stats">Stats</a></li>
                    <li id="search"><a href="index.php?p=recherches">Recherche</a></li>
                </ul>
            </nav>
        </header>
    </div>

    <div class="container">
    <?php
        print $content;
    ?>

    <hr>

    <div id="footer-wrapper">
        <footer id="footer" class="container">
            <div class="row">
                <div class="3u 6u(medium) 12u$(small)">
                    <section class="widget links">
                        <h3>La gestion des arbres à Paris</h3>
                            <p>Tout au long de l’année, la Mairie de Paris assure la surveillance du patrimoine arboré, le remplacement des arbres dépérissant et l’installation de nouvelles plantations.
                                <br/><br/>
                            Le cycle de vie d’un arbre est identique en milieu naturel et en milieu urbain, toutefois, les contraintes spécifiques de la ville exigent un accompagnement attentif de chaque arbre et le renouvellement des sujets dépérissant.</p>
                    </section>
                </div>
                <div class="3u 6u$(medium) 12u$(small)">
                    <section class="widget links">
                        <h3>Avant la plantation</h3>
                        <p>Les arbres sont cultivés en pépinière en moyenne 8 à 10 ans avant d’être plantés en ville.
                            <br/><br/>
                            Pour planter l’arbre, une fosse de plantation doit être creusée et remplie de terre végétale.
                            <br/><br/>
                            e volume de la fosse de plantation est d’environ 12 mètres cubes pour permettre un développement satisfaisant du système racinaire et une alimentation en eau et en éléments nutritifs appropriées à sa croissance.
                        </p>
                    </section>
                </div>
                <div class="3u 6u(medium) 12u$(small)">
                    <section class="widget links">
                        <h3>La plantation et les 3 premières années de croissance</h3>
                        <p>Une fois planté, des soins sont apportés à l’arbre pendant 3 ans pour garantir une bonne reprise et un développement harmonieux : il est arrosé régulièrement (environ 100 litres d’eau tous les 15 jours de mars à septembre) ; un tuteur est installé pour lui assurer une bonne stabilité le temps que les racines d’ancrages soient suffisamment développées, et des tailles de formation sont réalisées pour lui donner progressivement sa silhouette d’arbre adulte.
                            <br/><br/>
                            Après ces 3 premières années, l’arbre en pleine croissance ne nécessite plus de soin particulier.
                        </p>
                    </section>
                </div>
                <div class="3u 6u$(medium) 12u$(small)">
                    <section class="widget contact last">
                        <h3>Contactez-nous</h3>
                        <ul>
                            <li><a href="#" class="icon fa-twitter"><span
                                        class="label">Twitter</span></a></li>
                            <li><a href="#" class="icon fa-facebook"><span
                                        class="label">Facebook</span></a></li>
                            <li><a href="#" class="icon fa-instagram"><span
                                        class="label">Instagram</span></a></li>
                            <li><a href="#" class="icon fa-dribbble"><span
                                        class="label">Dribbble</span></a></li>
                            <li><a href="#" class="icon fa-pinterest"><span
                                        class="label">Pinterest</span></a></li>
                        </ul>
                        <p>
                            1234 Fictional Road<br /> Nashville, TN 00000<br /> (800)
                            555-0000
                        </p>
                    </section>

                </div>
            </div>
            <div class="row">
                <div class="12u">
                    <div id="copyright">
                        <ul class="menu">
                            <li>&copy; 2018. All rights reserved</li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
</div>

<!-- Script JS -->
<script src="public/js/jquery.min.js"></script>
<script src="public/js/jquery.dropotron.min.js"></script>
<script src="public/js/skel.min.js"></script>
<script src="public/js/util.js"></script>
<script src="public/js/main.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>

</body>
</html>
