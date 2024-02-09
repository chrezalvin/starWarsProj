<?php
    require_once '../service/people.php';

    $people;
    $update = null;
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $id = $_POST['id'];
        $name = $_POST['name'];
        $height = $_POST['height'];
        $mass = $_POST['mass'];
        $hair_color = $_POST['hair_color'];
        $skin_color = $_POST['skin_color'];
        $eye_color = $_POST['eye_color'];
        $birth_year = $_POST['birth_year'];
        $gender = $_POST['gender'];

        $update = PeopleDatabase::update_people(
                                            $id, 
                                            $name, 
                                            $height, 
                                            $mass, 
                                            $hair_color, 
                                            $skin_color, 
                                            $eye_color, 
                                            $birth_year, 
                                            $gender
                                        );
        
    }

    $id = $_GET['id'];
    $people = PeopleDatabase::get_people_by_id($id);

