<?php
    require '../include/session.php';
    require_once '../service/people.php';
    require_once '../include/FileManager.php';

    try{
        $fileManager = new FileManager("../public/people");
        $deleteId = $_POST['deleteId'] ?? null;
    
        $response = false;

        $errorMessage =  null;
    
        if($deleteId){
            $response = PeopleDatabase::delete_people_by_id($deleteId);
            $fileManager->deletePhoto(strval($deleteId));
        }
        else
            $errorMessage = "Invalid ID";

        header('Location: ./monitor_people.php'.($errorMessage ? "?error=$errorMessage" : ""));
    }
    catch(Exception $e){
        $error = $e->getMessage();
        header('Location: ./monitor_people.php'.($error ? "?error=$error" : ""));
    }