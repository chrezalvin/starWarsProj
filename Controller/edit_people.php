<?php
    require '../include/session.php';
    
    require_once '../service/people.php';
    require_once '../include/FileManager.php';

    try{
        $people;
        $update = null;
        $errorMessage = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id =           sanitizeInputInt($_POST['id']);
            $name =         sanitizeInputStr($_POST['name']);
            $height =       sanitizeInputInt($_POST['height']);
            $mass =         sanitizeInputInt($_POST['mass']);
            $hair_color =   sanitizeInputStr($_POST['hair_color']);
            $skin_color =   sanitizeInputStr($_POST['skin_color']);
            $eye_color =    sanitizeInputStr($_POST['eye_color']);
            $birth_year =   sanitizeInputStr($_POST['birth_year'].$_POST['birth_year_indicator']);
            $gender =       sanitizeInputStr($_POST['gender']);
            $home_world =   sanitizeInputInt($_POST['homeworld']);

            $photo = $_FILES['photo'] ?? null;

            $photoName = null;
            if(FileManager::isFileValid($photo)){
                $extension = pathinfo($photo['name'], PATHINFO_EXTENSION);
                $fileName = $id.".$extension";

                $photoManager = new FileManager("../public/people");
                $photoManager->savePhoto($photo, $fileName);
                $photoName = $fileName;
            }
    
            $update = PeopleDatabase::update_people(
                                                $id, 
                                                $name, 
                                                $height, 
                                                $mass, 
                                                $hair_color, 
                                                $skin_color, 
                                                $eye_color, 
                                                $birth_year, 
                                                $gender,
                                                $home_world,
                                                $photoName
                                            );
        }
        else
            $errorMessage = "Invalid request method";

        header('Location: ./monitor_people.php'.($errorMessage ? "?error=$errorMessage" : ""));
    }
    catch(Exception $e){
        $error = htmlspecialchars($e->getMessage());
        var_dump($error);
        header('Location: ./monitor_people.php'.($error ? "?error=$error" : ""));
    }