<?php
    require_once('../include/database.php');
    require_once('../Model/Planet.php');

    class PlanetDatabase{
        private static $table = "planets";

        private function __construct(){}

        static function get_all_planets(string $search = null){
            $table = self::$table;

            $query = "SELECT * FROM $table LIMIT 20";
            $result = database()->query($query);
            $planets = [];
            while($row = mysqli_fetch_assoc($result))
                $planets[] = Planet::get_planet_from_query($row);

            if($search != null){
                $planets = array_filter($planets, function(Planet $planet) use ($search)
                {
                    return strpos(strtolower($planet->getName()), strtolower($search)) !== false;
                });
            }
            
            return $planets;
        }
    
        static function get_planet_by_id($id){
            $table = self::$table;

            $query = "SELECT * FROM $table WHERE `id` = '$id'";
            $result = database()->query($query);
            $row = mysqli_fetch_assoc($result);
            return Planet::get_planet_from_query($row);
        }

        static function validate_planet(
            $name, 
        ){
            if($name == null)
                throw new Exception("Name cannot be null"); 
        }

        static function update_planet(
            int $id, 
            string $name, 
            int | null $rotation_period, 
            int | null $orbital_period, 
            int | null $diameter, 
            string | null $climate, 
            string | null $gravity, 
            string | null $terrain, 
            int | null $surface_water, 
            int | null $population
        )
        {
            PlanetDatabase::validate_planet($name);

            $table = self::$table;

            // turn null -> 'null' and sanitize the inputs
            $query = "UPDATE `$table` SET 
                `name` = ".($name ? "'".htmlspecialchars($name)."'" : "null").", 
                `rotation_period` = ".($rotation_period ? "'".htmlspecialchars($rotation_period)."'" : "null").", 
                `orbital_period` = ".($orbital_period ? "'".htmlspecialchars($orbital_period)."'" : "null").", 
                `diameter` = ".($diameter ? "'".htmlspecialchars($diameter)."'" : "null").", 
                `climate` = ".($climate ? "'".htmlspecialchars($climate)."'" : "null").", 
                `gravity` = ".($gravity ? "'".htmlspecialchars($gravity)."'" : "null").", 
                `terrain` = ".($terrain ? "'".htmlspecialchars($terrain)."'" : "null").", 
                `surface_water` = ".($surface_water ? "'".htmlspecialchars($surface_water)."'" : "null").", 
                `population` = ".($population ? "'".htmlspecialchars($population)."'" : "null")." 
                WHERE `id` = $id";

            return database()->query($query);
        }

        static function delete_planet_by_id($id){
            $table = self::$table;
            $query = "DELETE FROM $table WHERE `id` = '$id'";
            return database()->query($query);
        }

        static function create_planet(
            string $name, 
            int | null $rotation_period, 
            int | null $orbital_period, 
            int | null $diameter, 
            string | null $climate, 
            string | null $gravity, 
            string | null $terrain, 
            int | null $surface_water, 
            int | null $population
        ){
            PlanetDatabase::validate_planet($name);

            $table = self::$table;

            // turn null -> 'null' and sanitize the inputs
            $query = "INSERT INTO `$table` (`name`, `rotation_period`, `orbital_period`, `diameter`, `climate`, `gravity`, `terrain`, `surface_water`, `population`) VALUES (
                ".($name ? "'".htmlspecialchars($name)."'" : "null").", 
                ".($rotation_period ? "'".htmlspecialchars($rotation_period)."'" : "null").", 
                ".($orbital_period ? "'".htmlspecialchars($orbital_period)."'" : "null").", 
                ".($diameter ? "'".htmlspecialchars($diameter)."'" : "null").", 
                ".($climate ? "'".htmlspecialchars($climate)."'" : "null").", 
                ".($gravity ? "'".htmlspecialchars($gravity)."'" : "null").", 
                ".($terrain ? "'".htmlspecialchars($terrain)."'" : "null").", 
                ".($surface_water ? "'".htmlspecialchars($surface_water)."'" : "null").", 
                ".($population ? "'".htmlspecialchars($population)."'" : "null").")";

            return database()->query($query);
        }

        static function get_planet_by_name($name){
            $table = self::$table;

            $query = "SELECT * FROM $table WHERE `name` = '$name'";
            $result = database()->query($query);
            $row = mysqli_fetch_assoc($result);
            return Planet::get_planet_from_query($row);
        }

        static function search_planet($name){
            $table = self::$table;
            $query = "SELECT * FROM $table WHERE `name` LIKE '%$name%'";
            $result = database()->query($query);
            $planets = [];
            while($row = mysqli_fetch_assoc($result))
                $planets[] = Planet::get_planet_from_query($row);
            return $planets;
        }
}