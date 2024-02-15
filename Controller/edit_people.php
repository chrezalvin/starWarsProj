<?php
    require '../include/session.php';
    
    require_once '../service/people.php';
    require_once '../include/FileManager.php';

    try{
        $people;
        $update = null;
        $errorMessage = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $name = $_POST['name'];
            $height = $_POST['height'];
            $mass = $_POST['mass'];
            $hair_color = $_POST['hair_color'];
            $skin_color = $_POST['skin_color'];
            $eye_color = $_POST['eye_color'];
            $birth_year = $_POST['birth_year'].$_POST['birth_year_indicator'];
            $gender = $_POST['gender'];
            $home_world = $_POST['homeworld'];

            $photo = $_FILES['photo'] ?? null;

            $photoName = null;
            if($photo !== null){
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
        $error = $e->getMessage();
        header('Location: ./monitor_people.php'.($error ? "?error=$error" : ""));
    }