<?php

    require_once('../include/database.php');
    require_once('../Model/planetView.php');

    class PlanetViewDatabase {
        private static $table = "planets_view";

        private function __construct(){}

        static function get_view(){
            $table = self::$table;

            $query = pdo()->query("SELECT * FROM $table LIMIT 20");
            $data = $query->fetchAll();

            $planet = [];
            foreach($data as $row)
                $planet[] = PlanetView::get_planet_view_from_query($row);

            return $planet;
        }
    }