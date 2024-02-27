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

            $query = "SELECT * FROM $table LIMIT 20";
            $stmt = pdo()->query($query);
            $data = $stmt->fetchAll();
            
            return json_encode($data);
        }

        /**
         * @param PlanetView[] $planetView
         */
        static function generateLabeledElement($planetView){
            return [
                "Name" => array_map(fn(PlanetView $planet) => $planet->getName(), $planetView),
                "Rotation Period" => array_map(fn(PlanetView $planet) => $planet->getRotationPeriod(), $planetView),
                "Orbital Period" => array_map(fn(PlanetView $planet) => $planet->getOrbitalPeriod(), $planetView),
                "Diameter" => array_map(fn(PlanetView $planet) => $planet->getDiameter(), $planetView),
                "Climate" => array_map(fn(PlanetView $planet) => $planet->getClimate(), $planetView),
                "Gravity" => array_map(fn(PlanetView $planet) => $planet->getGravity(), $planetView),
                "Terrain" => array_map(fn(PlanetView $planet) => $planet->getTerrain(), $planetView),
                "Surface Water" => array_map(fn(PlanetView $planet) => $planet->getSurfaceWater(), $planetView),
            ];
        }
    }