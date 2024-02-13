<?php

    require_once '../Model/User.php';
    require_once '../include/database.php';

    class UserDatabase{
        private static $table = "users";

        private function __construct(){}

        static function register(User $user): bool{
            $table = self::$table;
            $username = $user->getUsername();
            $password = $user->getPassword();

            $query = "INSERT INTO `$table` (`username`, `password`) VALUES ('$username', PASSWORD('$password'))";
            return database()->query($query);
        }

        static function login(string $username, string $password): User | null{
            $table = self::$table;

            $query = "SELECT * FROM `$table` WHERE `username` = '$username' AND `password` = PASSWORD('$password')";
            $result = database()->query($query);

            if($result->num_rows == 0)
                return null;
            else{
                $row = mysqli_fetch_assoc($result);
                return User::get_user_from_query($row);
            }
        }
    }