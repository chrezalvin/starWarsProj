<?php
    require '../include/session.php';
    require_once '../service/people.php';
    require_once '../include/FileManager.php';
    require_once '../include/library.php';

    try{
        $fileManager = new FileManager("../public/people");
        $deleteId = sanitizeInputInt($_POST['deleteId']);
    
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