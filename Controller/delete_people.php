<?php
    require '../include/session.php';
    require_once '../service/People.php';
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

        header('Location: ./monitor.php?page=people'.($errorMessage ? "?error=$errorMessage" : ""));
    }
    catch(Exception $e){
        $error = $e->getMessage();
        header('Location: ./monitor.php?page=people'.($error ? "?error=$error" : ""));
    }