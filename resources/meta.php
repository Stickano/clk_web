<?php
    # This document handles meta/head data
    # This document should be loaded once per page


    # Singleton & Controller shortcut
    require_once('resources/singleton.php');
    $singleton  = Singleton::init();
    $controller = $singleton::$controller;

    # Meta
    # Control the Robot tag with; index, noindex, follow, nofollow
    # The index option tell the crawler if you want the page indexed
    # The follow option tells if you want links on the page to be followed

    echo'<title></title>';
    echo'<link rel="alternate" href="https://web.site" hreflang="dk" />';
    echo'<link rel="shortcut icon" href="media/ico.ico">';
    echo'<meta charset="utf-8" />';
    echo'<meta http-equiv="X-UA-Compatible" content="IE=edge" />';
    echo'<meta name="author" content="John Doe" />';
    echo'<meta name="description" content="A short description of your site" />';
    echo'<meta name="keywords" content="comma, separated, keywords" />';
    echo'<meta name="robots" content="index, follow" />';
    echo'<meta name="viewport" content="width=device-width, initial-scale=0.8" />';

    # Stylesheet(s)
    echo'<link href="css/styles.css" rel="stylesheet">';

    # CDNs.
    # Font Awesome
    // echo'<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">';

    # VueJs
    # Development version, includes helpful console warnings
    // echo'<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>';
    # Production version, optimized for size and speed
    // echo'<script src="https://cdn.jsdelivr.net/npm/vue"></script>';

    # Jquery
    echo'<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>';
?>