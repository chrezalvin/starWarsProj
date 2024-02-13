<?php
    require '../include/session.php';
    require_once '../service/Planet.php';
    require_once '../service/PlanetView.php';

    $search = $_GET['search'] ?? null;
    $planets = PlanetViewDatabase::get_view();

    if($search != null){
        $planets = array_filter($planets, function(Planet $planet) use ($search)
        {
            return strpos(strtolower($planet->getName()), strtolower($search)) !== false;
        });
    }

    $response = false;

    $error =  $_GET['error'] ?? null;