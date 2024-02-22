<?php
    require '../include/session.php';
    require_once '../service/Vehicle.php';
    require_once '../include/FileManager.php';
    require_once '../include/library.php';

    try{
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
            $fileName = VehicleDatabase::get_next_id().".$extension";
            $photoManager = new FileManager("../public/vehicle");
            $photoManager->savePhoto($photo, $fileName);
            $photoName = $fileName;
        }

        $error = null;
        $add = VehicleDatabase::create_vehicle(
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
            $photoName,
        );

        if(!$add)
            $error = "Failed to add vehicle";

        header('Location: ./monitor_vehicle.php'.($error ? "?error=$error" : ""));
    }
    catch(Exception $e){
        $error = $e->getMessage();
        header('Location: ./monitor_vehicle.php'.($error ? "?error=$error" : ""));
    }