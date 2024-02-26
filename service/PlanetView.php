<?php

    require_once('../include/database.php');
    require_once('../Model/planetView.php');

    class PlanetViewDatabase {
        private static $table = "planets_view";

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
            $planets = array_map(fn($row) => PlanetView::get_planet_view_from_query($row), $data);

            return $planets;
        }

        static function get_view_as_json(){
            $table = self::$table;

            $query = "SELECT * FROM $table LIMIT 20";
            $stmt = pdo()->query($query);
            $data = $stmt->fetchAll();
            
            return json_encode($data);
        }
    }