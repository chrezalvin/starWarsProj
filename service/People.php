<?php
    require_once('../include/database.php');
    require_once('../Model/People.php');

    class PeopleDatabase{
        private static $table = "people";

        private function __construct(){}

        static function get_all_people(){
            $table = self::$table;

            $query = "SELECT * FROM $table LIMIT 20";
            $result = database()->query($query);
            $people = [];
            while($row = mysqli_fetch_assoc($result))
                $people[] = People::get_people_from_query($row);
            return $people;
        }
    
        static function get_people_by_id($id){
            $table = self::$table;

            $query = "SELECT * FROM $table WHERE `id` = '$id'";
            $result = database()->query($query);
            $row = mysqli_fetch_assoc($result);
            return People::get_people_from_query($row);
        }

        static function validate_person(
            $name,
            $height,
            $mass,
            $hair_color,
            $skin_color,
            $eye_color,
            $birth_year,
            $gender,
            $homeworld
        ){
            if($name == null)
                throw new Exception("Name cannot be null");

            if($height == null || $height < 0)
                throw new Exception("Height cannot be null or negative");

            if($mass == null || $mass < 0)
                throw new Exception("Mass cannot be null or negative");

            // <year><BBY/ABY>
            if($birth_year == null || preg_match("/\d{1,5}(BBY|ABY)/", $birth_year) !== 1)
                throw new Exception("Invalid birth year format.");
        }

        static function update_people(
            int $id, 
            string $name, 
            ?int $height, 
            ?int $mass, 
            ?string $hair_color, 
            ?string $skin_color, 
            ?string $eye_color, 
            ?string $birth_year, 
            ?string $gender, 
            ?string $homeworld,
            ?string $photo
        )
        {
            PeopleDatabase::validate_person($name, $height, $mass, $hair_color, $skin_color, $eye_color, $birth_year, $gender, $homeworld);

            $table = self::$table;
            $query = "UPDATE `$table` SET 
                `name` = '$name', 
                `height` = '$height', 
                `mass` = '$mass', 
                `hair_color` = '$hair_color', 
                `skin_color` = '$skin_color', 
                `eye_color` = '$eye_color', 
                `birth_year` = '$birth_year', 
                `gender` = '$gender', 
                `homeworld` = '$homeworld',
                `img_url` = ".($photo ? "'".htmlspecialchars($photo)."'" : "null")."
                WHERE `id` = $id";

            $res = database()->query($query);
            return $res;
        }

        static function delete_people_by_id(int $id){
            $table = self::$table;
            $query = "DELETE FROM $table WHERE `id` = '$id'";
            return database()->query($query);
        }

        static function search_people($name){
            $table = self::$table;
            $query = "SELECT * FROM $table WHERE `name` LIKE '%$name%'";
            $result = database()->query($query);
            $people = [];
            while($row = mysqli_fetch_assoc($result))
                $people[] = People::get_people_from_query($row);
            return $people;
        }

        static function create_people(
            string $name, 
            ?int $height, 
            ?int $mass, 
            ?string $hair_color, 
            ?string $skin_color, 
            ?string $eye_color, 
            ?string $birth_year, 
            ?string $gender,
            ?string $homeworld,
            ?string $photo
        ){
            PeopleDatabase::validate_person($name, $height, $mass, $hair_color, $skin_color, $eye_color, $birth_year, $gender, $homeworld);

            // sanitize the inputs
            $name = htmlspecialchars($name);
            $height = htmlspecialchars($height);
            $mass = htmlspecialchars($mass);
            $hair_color = htmlspecialchars($hair_color);
            $skin_color = htmlspecialchars($skin_color);
            $eye_color = htmlspecialchars($eye_color);
            $birth_year = htmlspecialchars($birth_year);
            $gender = htmlspecialchars($gender);
            $homeworld = htmlspecialchars($homeworld);
            $photo = htmlspecialchars($photo);

            $table = self::$table;
            $query = "INSERT INTO $table (`name`, `height`, `mass`, `hair_color`, `skin_color`, `eye_color`, `birth_year`, `gender`, `homeworld`, `img_url`) VALUES ('$name', '$height', '$mass', '$hair_color', '$skin_color', '$eye_color', '$birth_year', '$gender', '$homeworld', '$photo')";
            return database()->query($query);
        }

        static function get_next_id(){
            $table = self::$table;
            $query = "SHOW TABLE STATUS LIKE '$table'";
            $result = database()->query($query);
            $row = mysqli_fetch_assoc($result);
            return $row['Auto_increment'];
        }
    }