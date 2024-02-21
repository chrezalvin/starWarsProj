<?php
    require_once '../Model/Vehicle.php';
    require_once '../include/database.php';

    class VehicleDatabase{
        private static $table = "vehicles";

        private function __construct(){}

        static function get_all_vehicles(){
            $table = self::$table;

            $query = "SELECT * FROM $table";
            $result = database()->query($query);
            $vehicles = [];

            while($row = mysqli_fetch_assoc($result))
                $vehicles[] = Vehicle::get_vehicle_from_query($row);

            return $vehicles;
        }

        static function delete_vehicle_by_id(int $id): bool{
            $table = self::$table;

            $query = "DELETE FROM $table WHERE id = $id";
            return database()->query($query);
        }

        static function edit_vehicle_by_id(
            int $id,
            string $name,
            ?string $model,
            ?string $manufacturer,
            ?int $cost_in_credits,
            ?float $length,
            ?int $max_atmosphering_speed,
            ?int $crew,
            ?int $passengers,
            ?int $cargo_capacity,
            ?string $consumables,
            ?string $vehicle_class,
            ?string $img_url
        ): bool{
            $table = self::$table;

            // turn null -> 'null' and sanitize the inputs
            $query = "UPDATE $table SET 
                `name` = ".($name ? "'".htmlspecialchars($name)."'" : "null").", 
                `model` = ".($model ? "'".htmlspecialchars($model)."'" : "null").", 
                `manufacturer` = ".($manufacturer ? "'".htmlspecialchars($manufacturer)."'" : "null").", 
                `cost_in_credits` = ".($cost_in_credits ? "'".htmlspecialchars($cost_in_credits)."'" : "null").", 
                `length` = ".($length ? "'".htmlspecialchars($length)."'" : "null").", 
                `max_atmosphering_speed` = ".($max_atmosphering_speed ? "'".htmlspecialchars($max_atmosphering_speed)."'" : "null").", 
                `crew` = ".($crew ? "'".htmlspecialchars($crew)."'" : "null").", 
                `passengers` = ".($passengers ? "'".htmlspecialchars($passengers)."'" : "null").", 
                `cargo_capacity` = ".($cargo_capacity ? "'".htmlspecialchars($cargo_capacity)."'" : "null").", 
                `consumables` = ".($consumables ? "'".htmlspecialchars($consumables)."'" : "null").", 
                `vehicle_class` = ".($vehicle_class ? "'".htmlspecialchars($vehicle_class)."'" : "null")."
                ".($img_url ? ", `img_url`='".htmlspecialchars($img_url)."'": "")."
                WHERE `id` = $id";

            return database()->query($query);
        }

        static function create_vehicle(
            string $name,
            ?string $model,
            ?string $manufacturer,
            ?int $cost_in_credits,
            ?float $length,
            ?int $max_atmosphering_speed,
            ?int $crew,
            ?int $passengers,
            ?int $cargo_capacity,
            ?string $consumables,
            ?string $vehicle_class,
            ?string $img_url,
        ): bool{
            $table = self::$table;

            // turn null -> 'null' and sanitize the inputs
            $query = "INSERT INTO $table (`name`, `model`, `manufacturer`, `cost_in_credits`, `length`, `max_atmosphering_speed`, `crew`, `passengers`, `cargo_capacity`, `consumables`, `vehicle_class`, `img_url`) VALUES (
                ".($name ? "'".htmlspecialchars($name)."'" : "null").", 
                ".($model ? "'".htmlspecialchars($model)."'" : "null").", 
                ".($manufacturer ? "'".htmlspecialchars($manufacturer)."'" : "null").", 
                ".($cost_in_credits ? "'".htmlspecialchars($cost_in_credits)."'" : "null").", 
                ".($length ? "'".htmlspecialchars($length)."'" : "null").", 
                ".($max_atmosphering_speed ? "'".htmlspecialchars($max_atmosphering_speed)."'" : "null").", 
                ".($crew ? "'".htmlspecialchars($crew)."'" : "null").", 
                ".($passengers ? "'".htmlspecialchars($passengers)."'" : "null").", 
                ".($cargo_capacity ? "'".htmlspecialchars($cargo_capacity)."'" : "null").", 
                ".($consumables ? "'".htmlspecialchars($consumables)."'" : "null").", 
                ".($vehicle_class ? "'".htmlspecialchars($vehicle_class)."'" : "null").",
                ".($img_url ? "'".htmlspecialchars($img_url)."'" : "null")."
            )";

            return database()->query($query);
        }

        static function get_next_id(){
            $table = self::$table;

            $query = "SHOW TABLE STATUS LIKE '$table'";
            $result = database()->query($query);
            $row = mysqli_fetch_assoc($result);
            return $row['Auto_increment'];
        }

        static function get_vehicle_by_name(string $name): Vehicle | null{
            $table = self::$table;

            $query = "SELECT * FROM $table WHERE `name` = '$name'";
            $result = database()->query($query);
            $row = mysqli_fetch_assoc($result);

            return $row ? Vehicle::get_vehicle_from_query($row) : null;
        }
    }