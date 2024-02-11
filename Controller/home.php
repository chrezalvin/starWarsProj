<?php
    require_once '../service/people.php';

    $deleteId = $_GET['deleteId'] ?? null;
    $search = $_GET['search'] ?? null;
    $error = $_GET['error'] ?? null;

    $people = PeopleDatabase::get_all_people();
    if($search != null){
        $people = array_filter($people, function(People $person) use ($search)
        {
            return strpos(strtolower($person->getName()), strtolower($search)) !== false;
        });
    }



