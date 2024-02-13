<?php
    require '../include/session.php';
    
    // edit planet
    require_once '../service/Planet.php';

    try{
        $id = $_POST['id'];
        $name = $_POST['name'];
        $rotation_period = $_POST['rotation_period'] ?? null;
        $orbital_period = $_POST['orbital_period'] ?? null;
        $diameter = $_POST['diameter'] ?? null;
        $climate = $_POST['climate'] ?? null;
        $gravity = $_POST['gravity'] ?? null;
        $terrain = $_POST['terrain'] ?? null;
        $surface_water = $_POST['surface_water'] ?? null;
        $population = $_POST['population'] ?? null;
        
        $update = PlanetDatabase::update_planet(
            $id,
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

        if(!$update)
            $error = "Failed to update planet";
        
        header('Location: ./monitor_planet.php'.($error ? "?error=$error" : ""));
    }
    catch(Exception $e){
        $error = $e->getMessage();
        header('Location: ./monitor_planet.php'.($error ? "?error=$error" : ""));
    }