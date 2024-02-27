<?php
    require '../include/session.php';
    require_once '../service/People.php';
    require_once '../include/FileManager.php';
    require_once '../include/library.php';

    try{
        $name =         sanitizeInputStr($_POST['name']);
        $height =       sanitizeInputInt($_POST['height']);
        $mass =         sanitizeInputInt($_POST['mass']);
        $hair_color =   sanitizeInputStr($_POST['hair_color']);
        $skin_color =   sanitizeInputStr($_POST['skin_color']);
        $eye_color =    sanitizeInputStr($_POST['eye_color']);
        $birth_year =   sanitizeInputStr($_POST['birth_year'].$_POST['birth_year_indicator']);
        $gender =       sanitizeInputStr($_POST['gender']);
        $homeworld =    sanitizeInputStr($_POST['homeworld']);

        $photo = $_FILES['photo'] ?? null;

        $photoName = null;
        if(FileManager::isFileValid($photo)){
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
        
        header('Location: ./monitor.php?page=people'.($error ? "?error=$error" : ""));
    }
    catch(Exception $e){
        $error = $e->getMessage();
        header('Location: ./monitor.php?page=people'.($error ? "?error=$error" : ""));
    }