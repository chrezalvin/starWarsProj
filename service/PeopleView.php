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

        /**
         * @param int[] $ids
         */
        static function get_view_by_ids($ids){
            $table = self::$table;

            $in = implode(',', array_fill(0, count($ids), '?'));
            $stmt = pdo()->prepare("SELECT * FROM $table WHERE `id` IN ($in)");
            $stmt->execute($ids);
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

        /**
         * @param PeopleView[] $peopleView
         */
        static function generateLabeledElements($peopleView){
            return [
                "Name" => array_map(fn(PeopleView $person) => $person->getName(), $peopleView),
                "Height" => array_map(fn(PeopleView $person) => $person->getHeight(), $peopleView),
                "Mass" => array_map(fn(PeopleView $person) => $person->getMass(), $peopleView),
                "Hair Color" => array_map(fn(PeopleView $person) => $person->getHairColor(), $peopleView),
                "Skin Color" => array_map(fn(PeopleView $person) => $person->getSkinColor(), $peopleView),
                "Eye Color" => array_map(fn(PeopleView $person) => $person->getEyeColor(), $peopleView),
                "Birth Year" => array_map(fn(PeopleView $person) => $person->getBirthYear(), $peopleView),
                "Gender" => array_map(fn(PeopleView $person) => $person->getGender(), $peopleView),
                "Homeworld" => array_map(fn(PeopleView $person) => $person->getHomeworld(), $peopleView)
            ];
        }
    }