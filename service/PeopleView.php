<?php

    require_once('../include/database.php');
    require_once('../include/library.php');
    require_once('../Model/PeopleView.php');

    class PeopleViewDatabase {
        private static $table = "people_view";

        private function __construct(){}

        static function get_view(?string $search = null){
            $table = self::$table;

            $stmt = null;
            if($search === null)
                $stmt = pdo()->query("SELECT * FROM $table LIMIT 20");
            else{
                $stmt = pdo()->prepare("SELECT * FROM $table WHERE `name` LIKE :search LIMIT 20");
                $stmt->execute(['search' => "%$search%"]);
            }

            $data = $stmt->fetchAll();
            $people = array_map(fn($row) => PeopleView::get_people_view_from_query($row), $data);

            return $people;
        }

        static function get_view_as_json(){
            $table = self::$table;

            $stmt = pdo()->query("SELECT * FROM $table LIMIT 20");
            $data = $stmt->fetchAll();
            
            return json_encode($data);
        }
    }