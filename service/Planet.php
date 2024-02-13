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

        static function update_planet($id, $name, $rotation_period, $orbital_period, $diameter, $climate, $gravity, $terrain, $surface_water, $population)
        {
            PlanetDatabase::validate_planet($name);

            $table = self::$table;
            $query = "UPDATE $table SET 
                `name` = '$name', 
                `rotation_period` = '$rotation_period', 
                `orbital_period` = '$orbital_period', 
                `diameter` = '$diameter', 
                `climate` = '$climate', 
                `gravity` = '$gravity', 
                `terrain` = '$terrain', 
                `surface_water` = '$surface_water', 
                `population` = '$population' 
                WHERE `id` = '$id'";
                
            return database()->query($query);
        }

        static function delete_planet_by_id($id){
            $table = self::$table;
            $query = "DELETE FROM $table WHERE `id` = '$id'";
            return database()->query($query);
        }

        static function create_planet($name, $rotation_period, $orbital_period, $diameter, $climate, $gravity, $terrain, $surface_water, $population){
            PlanetDatabase::validate_planet($name);

            $table = self::$table;
            $query = "INSERT INTO $table (`name`, `rotation_period`, `orbital_period`, `diameter`, `climate`, `gravity`, `terrain`, `surface_water`, `population`) VALUES ('$name', '$rotation_period', '$orbital_period', '$diameter', '$climate', '$gravity', '$terrain', '$surface_water', '$population')";

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