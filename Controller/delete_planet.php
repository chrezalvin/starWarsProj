<?php
    require '../include/session.php';
    
    //  delete planet
    require_once '../service/Planet.php';
    require_once '../include/FileManager.php';

    try{
        $fileManager = new FileManager("../public/planet");
        $deleteId = $_POST['deleteId'] ?? null;
    
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