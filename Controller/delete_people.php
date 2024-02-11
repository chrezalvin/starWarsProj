<?php

    require_once '../service/people.php';

    try{
        $deleteId = $_POST['deleteId'] ?? null;
        echo("delete ID: $deleteId");
    
        $people = PeopleDatabase::get_all_people();
    
        $response = false;

        $errorMessage =  null;
    
        if($deleteId)
            $response = PeopleDatabase::delete_people_by_id($deleteId);
        else
            $errorMessage = "Invalid ID";

        header('Location: ./monitor_people.php'.($errorMessage ? "?error=$errorMessage" : ""));
    }
    catch(Exception $e){
        $error = $e->getMessage();
        header('Location: ./monitor_people.php'.($error ? "?error=$error" : ""));
    }