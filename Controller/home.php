<?php
    require '../include/session.php';
    require_once '../service/people.php';
    require_once '../service/PeopleView.php';
    require_once '../service/Planet.php';
    require_once '../Model/FormInput.php';

    $deleteId = $_GET['deleteId'] ?? null;
    $search = $_GET['search'] ?? null;
    $error = $_GET['error'] ?? null;

    $allPlanetList = PlanetDatabase::get_all_planets();
    $people = PeopleViewDatabase::get_view();
    
    if($search != null){
        $people = array_filter($people, function(People $person) use ($search)
        {
            return strpos(strtolower($person->getName()), strtolower($search)) !== false;
        });
    }



