<?php
    require '../include/session.php';
    require_once '../service/vehicle.php';

    try{
        $id = $_POST['id'];
        $name = $_POST['name'];
        $model = $_POST['model'] ?? null;
        $manufacturer = $_POST['manufacturer'] ?? null;
        $cost_in_credits = intval($_POST['cost_in_credits']) == 0 ? null : intval($_POST['cost_in_credits']);
        $length = floatval($_POST['length']) == 0 ? null : intval($_POST['length']);
        $max_atmosphering_speed = intval($_POST['max_atmosphering_speed']) == 0 ? null : intval($_POST['max_atmosphering_speed']);
        $crew = intval($_POST['crew']) == 0 ? null : intval($_POST['crew']);
        $passengers = intval($_POST['passengers']) == 0 ? null : intval($_POST['passengers']);
        $cargo_capacity = intval($_POST['cargo_capacity']) == 0 ? null : intval($_POST['cargo_capacity']);
        $consumables = $_POST['consumables'] ?? null;
        $vehicle_class = $_POST['vehicle_class'] ?? null;

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
            $vehicle_class
        );
        
        $error = null;

        if(!$add)
            $error = "Failed to edit the vehicle";
        
        header('Location: ./monitor_vehicle.php'.($error ? "?error=$error" : ""));
    }
    catch(Exception $e){
        $error = $e->getMessage();
        header('Location: ./monitor_vehicle.php'.($error ? "?error=$error" : ""));
    }