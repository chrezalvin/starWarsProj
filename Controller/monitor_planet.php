<?php
    require '../include/session.php';
    require_once '../service/Planet.php';
    require_once '../service/PlanetView.php';


    $error =  $_GET['error'] ?? null;