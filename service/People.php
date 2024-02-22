<?php
    require_once('../include/database.php');
    require_once('../Model/People.php');
    require_once('../include/library.php');

    class PeopleDatabase{
        private static $table = "people";

        private function __construct(){}

        static function get_all_people(){
            $table = self::$table;
    
            $query = "SELECT * FROM $table";
            $stmt = pdo()->query($query);
            $data = $stmt->fetchAll();

            $people = [];
            foreach($data as $row)
                $people[] = People::get_people_from_query($row);
            return $people;
        }
    
        static function get_people_by_id($id){
            $table = self::$table;

            $stmt = pdo()->prepare("SELECT * FROM $table WHERE `id` = :id");
            $stmt->execute(['id' => $id]);
            

            $query = "SELECT * FROM $table WHERE `id` = '$id'";
            $result = database()->query($query);
            $row = mysqli_fetch_assoc($result);
            return People::get_people_from_query($row);
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
            ?int $homeworld,
            ?string $photo
        )
        {
            $table = self::$table;
            $stmt = pdo()->prepare("UPDATE `$table` SET 
            `name`= :name, 
            `height`= :height, 
            `mass`= :mass, 
            `hair_color`= :hair_color, 
            `skin_color`= :skin_color, 
            `eye_color`= :eye_color, 
            `birth_year`= :birth_year, 
            `gender`= :gender,
            ".(is_null($photo) ? "" : "`img_url`= :photo,")."
            `homeworld`= :homeworld
            WHERE `id` = :id
            ");

            $birth_year = People::isValidBirthYear($birth_year) ? $birth_year : null;

            $args = [
                'name' => $name,
                'height' => $height,
                'mass' => $mass,
                'hair_color' => $hair_color,
                'skin_color' => $skin_color,
                'eye_color' => $eye_color,
                'birth_year' => $birth_year,
                'gender' => $gender,
                'homeworld' => $homeworld,
                'id' => $id
            ];

            if(!is_null($photo))
                $args['photo'] = $photo;

            $res = $stmt->execute($args);

            return $res;
        }

        static function delete_people_by_id(int $id): bool{
            $table = self::$table;
            $stmt = pdo()->prepare("DELETE FROM $table WHERE `id` = :id");
            $res = $stmt->execute(['id' => $id]);

            return $res;
        }

        /**
         * @return People[]
         */
        static function search_people(string $name){
            $table = self::$table;
            $stmt = pdo()->prepare("SELECT * FROM $table WHERE `name` LIKE :name");
            $stmt->execute(['name' => "%$name%"]);

            $data = $stmt->fetchAll();

            $people = [];
            foreach($data as $row)
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
            ?int $homeworld,
            ?string $photo
        ){
            $table = self::$table;

            $stmt = pdo()->prepare(
                "INSERT INTO $table (`name`, `height`, `mass`, `hair_color`, `skin_color`, `eye_color`, `birth_year`, `gender`, `homeworld`, `img_url`)
                VALUES (:name, :height, :mass, :hair_color, :skin_color, :eye_color, :birth_year, :gender, :homeworld, :photo)"
            );

            $birth_year = People::isValidBirthYear($birth_year) ? $birth_year : null;

            $res = $stmt->execute([
                'name' => $name,
                'height' => $height,
                'mass' => $mass,
                'hair_color' => $hair_color,
                'skin_color' => $skin_color,
                'eye_color' => $eye_color,
                'birth_year' => $birth_year,
                'gender' => $gender,
                'homeworld' => $homeworld ?? 0,
                'photo' => $photo
            ]);

            return $res;
        }

        static function get_next_id(){
            $table = self::$table;
            $query = "SHOW TABLE STATUS LIKE '$table'";
            $result = database()->query($query);
            $row = mysqli_fetch_assoc($result);
            return $row['Auto_increment'];
        }

        static function get_people_by_name(string $name): People | null{
            $table = self::$table;

            $query = "SELECT * FROM $table WHERE `name` = '$name'";
            $result = database()->query($query);
            $row = mysqli_fetch_assoc($result);
            return $row ? People::get_people_from_query($row) : null;
        }
    }