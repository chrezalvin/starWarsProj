<?php

    require_once('../include/session.php');
    require_once('../service/Swapi.php');

    require_once('../service/People.php');
    require_once('../service/Planet.php');
    require_once('../service/Vehicle.php');

    $planetPage = isset($_GET['planetPage']) ? intval($_GET['planetPage']) : 1;
    $peoplePage = isset($_GET['peoplePage']) ? intval($_GET['peoplePage']) : 1;
    $vehiclePage = isset($_GET['vehiclePage']) ? intval($_GET['vehiclePage']) : 1;

    $people = SWAPIDatabase::get_all_people($peoplePage);
    $db_people = PeopleDatabase::get_all_people();

    $planets = SWAPIDatabase::get_all_planet($planetPage);
    $db_planets = PlanetDatabase::get_all_planets();

    $vehicles = SWAPIDatabase::get_all_vehicle($vehiclePage);
    $db_vehicles = VehicleDatabase::get_all_vehicles();