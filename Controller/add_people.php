<?php
    require '../include/session.php';
    require_once '../service/people.php';
    require_once '../include/FileManager.php';

    try{
        $name = $_POST['name'];
        $height = $_POST['height'];
        $mass = $_POST['mass'];
        $hair_color = $_POST['hair_color'];
        $skin_color = $_POST['skin_color'];
        $eye_color = $_POST['eye_color'];
        $birth_year = $_POST['birth_year'].$_POST['birth_year_indicator'];
        $gender =  $_POST['gender'];
        $homeworld = $_POST['homeworld'];

        $photo = $_FILES['photo'] ?? null;

        $photoName = null;
        if($photo !== null){
            $extension = pathinfo($photo['name'], PATHINFO_EXTENSION);
            $fileName = PeopleDatabase::get_next_id().".$extension";
            $photoManager = new FileManager("../public/people");
            $photoManager->savePhoto($photo, $fileName);
            $photoName = $fileName;
        }

        $add = PeopleDatabase::create_people(
            $name, 
            $height, 
            $mass, 
            $hair_color, 
            $skin_color, 
            $eye_color, 
            $birth_year, 
            $gender,
            $homeworld,
            $photoName
        );
        
        $error = null;

        if(!$add)
            $error = "Failed to add people";
        
        header('Location: ./monitor_people.php'.($error ? "?error=$error" : ""));
    }
    catch(Exception $e){
        $error = $e->getMessage();
        header('Location: ./monitor_people.php'.($error ? "?error=$error" : ""));
    }