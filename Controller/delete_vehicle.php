<?php
    require '../include/session.php';
    
    //  delete planet
    require_once '../service/Vehicle.php';
    require_once '../include/FileManager.php';
    require_once '../include/library.php';

    try{
        $fileManager = new FileManager("../public/vehicle");
        $deleteId = sanitizeInputInt($_POST['deleteId']);
    
        $response = false;

        $errorMessage =  null;
    
        if($deleteId){
            $response = VehicleDatabase::delete_vehicle_by_id($deleteId);
            $fileManager->deletePhoto(strval($deleteId));
        }
        else
            $errorMessage = "Invalid ID";

        header('Location: ./monitor.php?page=vehicle'.($errorMessage ? "?error=$errorMessage" : ""));
    }
    catch(Exception $e){
        $error = $e->getMessage();
        header('Location: ./monitor.php?page=vehicle'.($error ? "?error=$error" : ""));
    }