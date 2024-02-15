<?php
    require '../include/session.php';
    
    //  delete planet
    require_once '../service/vehicle.php';
    require_once '../include/FileManager.php';

    try{
        $fileManager = new FileManager("../public/vehicle");
        $deleteId = $_POST['deleteId'] ?? null;
    
        $response = false;

        $errorMessage =  null;
    
        if($deleteId){
            $response = VehicleDatabase::delete_vehicle_by_id($deleteId);
            $fileManager->deletePhoto(strval($deleteId));
        }
        else
            $errorMessage = "Invalid ID";

        header('Location: ./monitor_vehicle.php'.($errorMessage ? "?error=$errorMessage" : ""));
    }
    catch(Exception $e){
        $error = $e->getMessage();
        header('Location: ./monitor_vehicle.php'.($error ? "?error=$error" : ""));
    }