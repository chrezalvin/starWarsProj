<?php
    require '../include/session.php';
    require_once '../service/VehicleView.php';
    require_once '../Model/VehicleView.php';

    $search = $_GET['search'] ?? null;
    $vehicles = VehicleViewDatabase::get_view();

    if($search != null){
        $vehicles = array_filter($vehicles, function(VehicleView $vehicle) use ($search)
        {
            return strpos(strtolower($vehicle->getName()), strtolower($search)) !== false;
        });
    }

    $response = false;

    $error =  $_GET['error'] ?? null;