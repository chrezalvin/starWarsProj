<?php

    require_once('../include/database.php');
    require_once('../Model/PeopleView.php');

    class PeopleViewDatabase {
        private static $table = "people_view";

        private function __construct(){}

        static function get_view(){
            $table = self::$table;

            $query = "SELECT * FROM $table LIMIT 20";
            $result = database()->query($query);
            $people = [];

            while($row = mysqli_fetch_assoc($result))
                $people[] = PeopleView::get_people_view_from_query($row);

            return $people;
        }
    }