<?php
    require '../include/session.php';
    require_once '../service/Planet.php';

    try{
        $name = $_POST['name'];
        $rotation_period = intval($_POST['rotation_period']) == 0 ? null : intval($_POST['rotation_period']);
        $orbital_period = intval($_POST['orbital_period']) == 0 ? null : intval($_POST['orbital_period']);
        $diameter = intval($_POST['diameter']) == 0 ? null : intval($_POST['diameter']);
        $climate = $_POST['climate'] ?? null;
        $gravity = $_POST['gravity'] ?? null;
        $terrain = $_POST['terrain'] ?? null;
        $surface_water = intval($_POST['surface_water']) == 0 ? null : intval($_POST['surface_water']);
        $population = intval($_POST['population']) == 0 ? null : intval($_POST['population']);
        
        $add = PlanetDatabase::create_planet(
            $name, 
            $rotation_period, 
            $orbital_period, 
            $diameter,
            $climate,
            $gravity,
            $terrain,
            $surface_water,
            $population
        );
        
        $error = null;

        if(!$add)
            $error = "Failed to add planet";
        
        header('Location: ./monitor_planet.php'.($error ? "?error=$error" : ""));
    }
    catch(Exception $e){
        $error = $e->getMessage();
        header('Location: ./monitor_planet.php'.($error ? "?error=$error" : ""));
    }