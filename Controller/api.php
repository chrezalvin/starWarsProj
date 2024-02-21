<?php
    require_once('../service/Swapi.php');

    require_once('../service/People.php');
    require_once('../service/Planet.php');
    require_once('../service/Vehicle.php');
    require_once('../Model/Base.php');

    require_once('../include/library.php');
    require_once('../include/session.php');

    /**
     * @param Base[] $refList
     * @param Base[] $refDB
     */
    function validate(int $id, $refList, $refDB): ?Base{
        // ignore if the id is not within the API list
        $find = search_array(fn(Base $ref) => $ref->getId() == $id, $refList);
        if($find)
            // check if the name is already exist within the database
            return search_array(fn(Base $ref) => $ref->getName() == $find->getName(), $refDB);

        return null;
    }

    $error = htmlspecialchars($_GET['error'] ?? "");
    $success = htmlspecialchars($_GET['success'] ?? "") ;

    // this is cookies to determine the page number of the swapi
    if(!isset($_SESSION['planetPage']))
        $_SESSION['planetPage'] = 1;
    if(!isset($_SESSION['peoplePage']))
        $_SESSION['peoplePage'] = 1;
    if(!isset($_SESSION['vehiclePage']))
        $_SESSION['vehiclePage'] = 1;

    // this is the list used for adding multiple items to the database
    if(!isset($_SESSION['planetList']))
        $_SESSION['planetList'] = [];
    if(!isset($_SESSION['peopleList']))
        $_SESSION['peopleList'] = [];
    if(!isset($_SESSION['vehicleList']))
        $_SESSION['vehicleList'] = [];

    if(isset($_GET['peoplePage']))
        $_SESSION['peoplePage'] = max(1, $_GET['peoplePage']);
    if(isset($_GET['planetPage']))
        $_SESSION['planetPage'] = max(1, $_GET['planetPage']);
    if(isset($_GET['vehiclePage']))
        $_SESSION['vehiclePage'] = max(1, $_GET['vehiclePage']);


    $peopleSwapi = SWAPIDatabase::get_response_bulk(SWAPIResource::PEOPLE, $_SESSION['peoplePage']);
    $planetSwapi = SWAPIDatabase::get_response_bulk(SWAPIResource::PLANET, $_SESSION['planetPage']);
    $vehicleSwapi = SWAPIDatabase::get_response_bulk(SWAPIResource::VEHICLE, $_SESSION['vehiclePage']);

    $peoplePage = $_SESSION['peoplePage'];
    $planetPage = $_SESSION['planetPage'];
    $vehiclePage = $_SESSION['vehiclePage'];

    /**
     * @var Base[] $planetList
     */
    $planetList = $_SESSION['planetList'];

    /**
     * @var Base[] $peopleList
     */
    $peopleList = $_SESSION['peopleList'];

    /**
     * @var Base[] $vehicleList
     */
    $vehicleList = $_SESSION['vehicleList'];

    $db_people = PeopleDatabase::get_all_people();
    $db_planets = PlanetDatabase::get_all_planets();
    $db_vehicles = VehicleDatabase::get_all_vehicles();

    // add to the list from get
    if(isset($_GET['addPlanet'])){
        $id = intval($_GET['addPlanet']);

        // check if planet is available in the api list
        $getBase = search_array(fn(Base $planet) => $planet->getId() == $id, $planetSwapi->getResults());

        if($getBase && !array_includes(fn(Base $base) => $base->getName() === $getBase->getName(), array_merge($db_planets, $planetList)))
            $planetList[] = $getBase;
    }

    if(isset($_GET['addPeople'])){
        $id = intval($_GET['addPeople']);

        // check if people is available in the api list
        $getBase = search_array(fn(Base $people) => $people->getId() == $id, $peopleSwapi->getResults());

        if($getBase && !array_includes(fn(Base $base) => $base->getName() === $getBase->getName(), array_merge($db_people, $peopleList)))
            $peopleList[] = $getBase;
    }

    if(isset($_GET['addVehicle'])){
        $id = intval($_GET['addVehicle']);

        // check if vehicle is available in the api list
        $getBase = search_array(fn(Base $vehicle) => $vehicle->getId() == $id, $vehicleSwapi->getResults());

        if($getBase && !array_includes(fn(Base $base) => $base->getName() === $getBase->getName(), array_merge($db_vehicles, $vehicleList)))
            $vehicleList[] = $getBase;
    }
    
    // sets the list to the cookies
    $_SESSION['planetList'] = $planetList;
    $_SESSION['peopleList'] = $peopleList;
    $_SESSION['vehicleList'] = $vehicleList;