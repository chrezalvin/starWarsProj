<?php
    require_once '../Model/Vehicle.php';
    require_once '../include/database.php';

    class VehicleDatabase{
        private static $table = "vehicles";

        private function __construct(){}

        static function get_all_vehicles(){
            $table = self::$table;

            $query = "SELECT * FROM $table";
            $stmt = pdo()->query($query);
            $data = $stmt->fetchAll();

            $vehicles = [];
            foreach($data as $row)
                $vehicles[] = Vehicle::get_vehicle_from_query($row);

            return $vehicles;
        }

        static function delete_vehicle_by_id(int $id): bool{
            $table = self::$table;

            $stmt = pdo()->prepare("DELETE FROM $table WHERE `id` = :id");
            $res = $stmt->execute(['id' => $id]);

            return $res;
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

            $stmt = pdo()->prepare("UPDATE $table SET 
                `name` = :name, 
                `model` = :model, 
                `manufacturer` = :manufacturer, 
                `cost_in_credits` = :cost_in_credits, 
                `length` = :length, 
                `max_atmosphering_speed` = :max_atmosphering_speed, 
                `crew` = :crew, 
                `passengers` = :passengers, 
                `cargo_capacity` = :cargo_capacity, 
                `consumables` = :consumables, 
                `vehicle_class` = :vehicle_class
                ".(is_null($img_url) ? "": ", `img_url`=:img_url")."
                WHERE `id` = :id"
            );

            $args = [
                'name' => $name,
                'model' => $model,
                'manufacturer' => $manufacturer,
                'cost_in_credits' => $cost_in_credits,
                'length' => $length,
                'max_atmosphering_speed' => $max_atmosphering_speed,
                'crew' => $crew,
                'passengers' => $passengers,
                'cargo_capacity' => $cargo_capacity,
                'consumables' => $consumables,
                'vehicle_class' => $vehicle_class,
                'id' => $id
            ];

            if(!is_null($img_url))
                $args['img_url'] = $img_url;

            $res = $stmt->execute($args);
            return $res;
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

            $stmt = pdo()->prepare("INSERT INTO $table (`name`, `model`, `manufacturer`, `cost_in_credits`, `length`, `max_atmosphering_speed`, `crew`, `passengers`, `cargo_capacity`, `consumables`, `vehicle_class`, `img_url`) VALUES (
                :name, 
                :model, 
                :manufacturer, 
                :cost_in_credits, 
                :length, 
                :max_atmosphering_speed, 
                :crew, 
                :passengers, 
                :cargo_capacity, 
                :consumables, 
                :vehicle_class,
                :img_url
            )");

            $args = [
                'name' => $name,
                'model' => $model,
                'manufacturer' => $manufacturer,
                'cost_in_credits' => $cost_in_credits,
                'length' => $length,
                'max_atmosphering_speed' => $max_atmosphering_speed,
                'crew' => $crew,
                'passengers' => $passengers,
                'cargo_capacity' => $cargo_capacity,
                'consumables' => $consumables,
                'vehicle_class' => $vehicle_class,
                'img_url' => $img_url
            ];

            $res = $stmt->execute($args);

            return $res;
        }

        static function get_next_id(){
            $table = self::$table;

            $query = "SHOW TABLE STATUS LIKE '$table'";
            $result = database()->query($query);
            $row = mysqli_fetch_assoc($result);
            return $row['Auto_increment'];
        }

        static function get_vehicle_by_name(string $name): ?Vehicle{
            $table = self::$table;

            $stmt = pdo()->prepare("SELECT * FROM $table WHERE `name` = :name");
            $stmt->execute(['name' => $name]);
            $row = $stmt->fetch();

            return $row ? Vehicle::get_vehicle_from_query($row) : null;
        }
    }