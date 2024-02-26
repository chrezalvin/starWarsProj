<?php
    require '../include/session.php';
    require_once '../service/vehicle.php';
    require_once '../include/FileManager.php';
    require_once '../include/library.php';

    try{
        $id =                       sanitizeInputInt($_POST['id']);
        $name =                     sanitizeInputStr($_POST['name']);
        $model =                    sanitizeInputStr($_POST['model']);
        $manufacturer =             sanitizeInputStr($_POST['manufacturer']);
        $cost_in_credits =          sanitizeInputInt($_POST['cost_in_credits']);
        $length =                   sanitizeInputInt($_POST['length']);
        $max_atmosphering_speed =   sanitizeInputInt($_POST['max_atmosphering_speed']);
        $crew =                     sanitizeInputInt($_POST['crew']);
        $passengers =               sanitizeInputInt($_POST['passengers']);
        $cargo_capacity =           sanitizeInputInt($_POST['cargo_capacity']);
        $consumables =              sanitizeInputStr($_POST['consumables']);
        $vehicle_class =            sanitizeInputStr($_POST['vehicle_class']);

        $photo = $_FILES['photo'] ?? null;

        $photoName = null;
        if(FileManager::isFileValid($photo)){
            $extension = pathinfo($photo['name'], PATHINFO_EXTENSION);
            $fileName = $id.".$extension";

            $photoManager = new FileManager("../public/vehicle");
            $photoManager->savePhoto($photo, $fileName);
            $photoName = $fileName;
        }

        $add = VehicleDatabase::edit_vehicle_by_id(
            $id,
            $name,
            $model,
            $manufacturer,
            $cost_in_credits,
            $length,
            $max_atmosphering_speed,
            $crew,
            $passengers,
            $cargo_capacity,
            $consumables,
            $vehicle_class,
            $photoName
        );
        
        $error = null;

        if(!$add)
            $error = "Failed to edit the vehicle";
        
        header('Location: ./monitor.php?page=vehicle'.($error ? "?error=$error" : ""));
    }
    catch(Exception $e){
        $error = $e->getMessage();
        header('Location: ./monitor.php?page=vehicle'.($error ? "?error=$error" : ""));
    }