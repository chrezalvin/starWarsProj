<?php
    require_once('../service/Swapi.php');
    require_once('../service/People.php');
    require_once('../service/Planet.php');
    require_once('../service/Vehicle.php');

    include_once('../include/session.php');
    
    // session type is Base[]
    $peopleList = $_SESSION['peopleList'];

    var_dump($peopleList);
    $vehicleList = $_SESSION['vehicleList'];
    $planetList = $_SESSION['planetList'];

    // ensure all of the post data is array of id's
    if(!is_array($peopleList) || !is_array($vehicleList) || !is_array($planetList)){
        header('Location: ./api.php?error=Invalid input');
        exit();
    }

    // counter for each array successfully added to the database
    $peopleCount = 0;
    $vehicleCount = 0;
    $planetCount = 0;

    foreach($peopleList as $person){
        if(!($person instanceof Base)){
            header('Location: ./api.php?error=Invalid input');
            exit();
        }

        $res = SWAPIDatabase::get_people($person->getId());

        if(!PeopleDatabase::get_people_by_name($person->getName())){
            $resp = PeopleDatabase::create_people(
                $res->getName(),
                $res->getHeight(),
                $res->getMass(),
                $res->getHairColor(),
                $res->getSkinColor(),
                $res->getEyeColor(),
                $res->getBirthYear(),
                $res->getGender(),
                null,
                null
            );
            var_dump($resp);
            if($resp);
                ++$peopleCount;
        }
    }

    foreach($vehicleList as $vehicle){
        if(!($vehicle instanceof Base)){
            header('Location: ./api.php?error=Invalid input');
            exit();
        }

        $res = SWAPIDatabase::get_vehicle($vehicle->getId());

        echo($res);

        if(!VehicleDatabase::get_vehicle_by_name($vehicle->getName()))
            if(VehicleDatabase::create_vehicle(
                $res->getName(),
                $res->getModel(),
                $res->getManufacturer(),
                $res->getCostInCredits(),
                $res->getLength(),
                $res->getMaxAtmospheringSpeed(),
                $res->getCrew(),
                $res->getPassengers(),
                $res->getCargoCapacity(),
                $res->getConsumables(),
                $res->getVehicleClass(),
                null
            ))
                ++$vehicleCount;
    }

    foreach($planetList as $planet){
        if(!($planet instanceof Base)){
            header('Location: ./api.php?error=Invalid input');
            exit();
        }

        $res = SWAPIDatabase::get_planet($planet->getId());

        if(!PlanetDatabase::get_planet_by_name($planet->getName()))
            if(PlanetDatabase::create_planet(
                $res->getName(),
                $res->getRotationPeriod(),
                $res->getOrbitalPeriod(),
                $res->getDiameter(),
                $res->getClimate(),
                $res->getGravity(),
                $res->getTerrain(),
                $res->getSurfaceWater(),
                $res->getPopulation(),
                null
            ))
            ++$planetCount;
    }


    $_SESSION['peopleList'] = [];
    $_SESSION['vehicleList'] = [];
    $_SESSION['planetList'] = [];

    if($peopleCount === 0 && $vehicleCount === 0 && $planetCount === 0){
        header('Location: ./api.php?error=Failed to add any data to the database');
    }
    else{
        $message = "Sucessfully added"
        .($peopleCount > 0 ? " $peopleCount people" : "")
        .($vehicleCount > 0 ? " $vehicleCount vehicles" : "")
        .($planetCount > 0 ? " $planetCount planets" : "")
        ." to the database";

        header('Location: ./api.php?success='.(htmlspecialchars($message)));
    }