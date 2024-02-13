<?php
    require '../include/session.php';
    require_once '../service/vehicle.php';

    $search = $_GET['search'] ?? null;
    $vehicles = VehicleDatabase::get_all_vehicles();

    if($search != null){
        $vehicles = array_filter($vehicles, function(Vehicle $vehicle) use ($search)
        {
            return strpos(strtolower($vehicle->getName()), strtolower($search)) !== false;
        });
    }

    $response = false;

    $error =  $_GET['error'] ?? null;