<?php
    require('../include/session.php');
    require_once('../service/planet.php');
    require_once('../include/FileManager.php');
    require_once('../include/library.php');

    try{
        $id =               sanitizeInputInt($_POST['id']);
        $name =             sanitizeInputStr($_POST['name']);
        $rotation_period =  sanitizeInputInt($_POST['rotation_period']);
        $orbital_period =   sanitizeInputInt($_POST['orbital_period']);
        $diameter =         sanitizeInputStr($_POST['diameter']);
        $climate =          sanitizeInputStr($_POST['climate']);
        $gravity =          sanitizeInputStr($_POST['gravity']);
        $terrain =          sanitizeInputStr($_POST['terrain']);
        $surface_water =    sanitizeInputInt($_POST['surface_water']);
        $population =       sanitizeInputInt($_POST['population']);

        $photo = $_FILES['photo'] ?? null;

        $photoName = null;
        if(FileManager::isFileValid($photo)){
            $extension = pathinfo($photo['name'], PATHINFO_EXTENSION);
            $fileName = $id.".$extension";

            $photoManager = new FileManager("../public/planet");
            $photoManager->savePhoto($photo, $fileName);
            $photoName = $fileName;
        }

        $add = PlanetDatabase::update_planet(
            $id,
            $name, 
            $rotation_period, 
            $orbital_period, 
            $diameter,
            $climate,
            $gravity,
            $terrain,
            $surface_water,
            $population,
            $photoName
        );
        
        $error = null;

        if(!$add)
            $error = "Failed to add planet";
        
        header('Location: ./monitor.php?page=planet'.($error ? "?error=$error" : ""));
    }
    catch(Exception $e){
        $error = $e->getMessage();
        var_dump($error);
        header('Location: ./monitor.php?page=planet'.($error ? "?error=$error" : ""));
    }