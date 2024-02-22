<?php
    require '../include/session.php';
    
    //  delete planet
    require_once '../service/Planet.php';
    require_once '../include/FileManager.php';
    require_once '../include/library.php';

    try{
        $fileManager = new FileManager("../public/planet");
        $deleteId = sanitizeInputInt($_POST['deleteId']);
    
        $planets = PlanetDatabase::get_all_planets();
    
        $response = false;

        $errorMessage =  null;
    
        if($deleteId){
            $response = PlanetDatabase::delete_planet_by_id($deleteId);
            $fileManager->deletePhoto(strval($deleteId));
        }
        else
            $errorMessage = "Invalid ID";

        header('Location: ./monitor_planet.php'.($errorMessage ? "?error=$errorMessage" : ""));
    }
    catch(Exception $e){
        $error = $e->getMessage();
        header('Location: ./monitor_planet.php'.($error ? "?error=$error" : ""));
    }