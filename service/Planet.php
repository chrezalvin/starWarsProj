<?php
    require_once('../include/database.php');
    require_once('../Model/Planet.php');

    class PlanetDatabase{
        private static $table = "planets";

        private function __construct(){}

        static function get_all_planets(string $search = null){
            $table = self::$table;

            $query = "SELECT * FROM $table LIMIT 20";
            $result = pdo()->query($query);
            $data = $result->fetchAll();

            $planets = [];
            foreach($data as $row)
                $planets[] = Planet::get_planet_from_query($row);

            if($search != null){
                $planets = array_filter($planets, function(Planet $planet) use ($search)
                {
                    return strpos(strtolower($planet->getName()), strtolower($search)) !== false;
                });
            }
            
            return $planets;
        }
    
        static function get_planet_by_id(int $id): Planet{
            $table = self::$table;

            $query = "SELECT * FROM $table WHERE `id` = '$id'";
            $result = pdo()->query($query);
            $row = $result->fetch();

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
            ?int $rotation_period, 
            ?int $orbital_period, 
            ?int $diameter, 
            ?string $climate, 
            ?string $gravity, 
            ?string $terrain, 
            ?int $surface_water, 
            ?int $population,
            ?string $img_url
        ): bool
        {
            PlanetDatabase::validate_planet($name);

            $table = self::$table;

            $stmt = pdo()->prepare("UPDATE `$table` SET 
                `name`= :name, 
                `rotation_period`= :rotation_period, 
                `orbital_period`= :orbital_period, 
                `diameter`= :diameter, 
                `climate`= :climate, 
                `gravity`= :gravity, 
                `terrain`= :terrain, 
                `surface_water`= :surface_water, 
                ".(is_null($img_url) ? "" : "`img_url`= :img_url,")."
                `population`= :population
                WHERE 
                `id` = :id");

            $args = [
                'name' => $name,
                'rotation_period' => $rotation_period,
                'orbital_period' => $orbital_period,
                'diameter' => $diameter,
                'climate' => $climate,
                'gravity' => $gravity,
                'terrain' => $terrain,
                'surface_water' => $surface_water,
                'population' => $population,
                'id' => $id
            ];

            if(!is_null($img_url))
                $args['img_url'] = $img_url;

            $res = $stmt->execute($args);

            return $res;
        }

        static function delete_planet_by_id(int $id): bool{
            $table = self::$table;

            $stmt = pdo()->prepare("DELETE FROM $table WHERE `id` = :id");
            $res = $stmt->execute(['id' => $id]);

            return $res;
        }

        static function create_planet(
            string $name, 
            ?int $rotation_period, 
            ?int $orbital_period, 
            ?int $diameter, 
            ?string $climate, 
            ?string $gravity, 
            ?string $terrain, 
            ?int $surface_water, 
            ?int $population,
            ?string $img_url
        ){
            PlanetDatabase::validate_planet($name);
            $table = self::$table;

            $stmt = pdo()->prepare("INSERT INTO `$table` 
            (`name`, `rotation_period`, `orbital_period`, `diameter`, `climate`, `gravity`, `terrain`, `surface_water`, `population`, `img_url`) 
            VALUES (
                :name, 
                :rotation_period, 
                :orbital_period, 
                :diameter, 
                :climate, 
                :gravity, 
                :terrain, 
                :surface_water, 
                :population, 
                :img_url)"
            );

            $res = $stmt->execute([
                'name' => $name,
                'rotation_period' => $rotation_period,
                'orbital_period' => $orbital_period,
                'diameter' => $diameter,
                'climate' => $climate,
                'gravity' => $gravity,
                'terrain' => $terrain,
                'surface_water' => $surface_water,
                'population' => $population,
                'img_url' => $img_url
            ]);

            return $res;
        }

        static function get_planet_by_name(string $name): ?Planet{
            $table = self::$table;

            $stmt = pdo()->prepare("SELECT * FROM $table WHERE `name` = :name");
            $stmt->execute(['name' => $name]);
            $row = $stmt->fetch();

            return $row ? Planet::get_planet_from_query($row) : null;
        }

        /**
         * @return Planet[]
         */
        static function search_planet(string $name){
            $table = self::$table;
            $stmt = pdo()->prepare("SELECT * FROM $table WHERE `name` LIKE :name");
            $stmt->execute(['name' => "%$name%"]);
            $data = $stmt->fetchAll();

            $planets = [];
            foreach($data as $row)
                $planets[] = Planet::get_planet_from_query($row);
            return $planets;
        }

        static function get_next_id(){
            $table = self::$table;
            $query = "SHOW TABLE STATUS LIKE '$table'";
            $result = database()->query($query);
            $row = mysqli_fetch_assoc($result);
            return $row['Auto_increment'];
        }
}