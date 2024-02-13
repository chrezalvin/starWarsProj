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

        static function edit_vehicle_by_id(Vehicle $vehicle): bool{
            $table = self::$table;
            $id = $vehicle->getId();
            $name = $vehicle->getName();
            $model = $vehicle->getModel();
            $manufacturer = $vehicle->getManufacturer();
            $cost_in_credits = $vehicle->getCostInCredits();
            $length = $vehicle->getLength();
            $max_atmosphering_speed = $vehicle->getMaxAtmospheringSpeed();
            $crew = $vehicle->getCrew();
            $passengers = $vehicle->getPassengers();
            $cargo_capacity = $vehicle->getCargoCapacity();
            $consumables = $vehicle->getConsumables();
            $vehicle_class = $vehicle->getVehicleClass();

            $query = "UPDATE $table SET name = '$name', model = '$model', manufacturer = '$manufacturer', cost_in_credits = $cost_in_credits, length = $length, max_atmosphering_speed = $max_atmosphering_speed, crew = $crew, passengers = $passengers, cargo_capacity = $cargo_capacity, consumables = '$consumables', vehicle_class = '$vehicle_class' WHERE id = $id";
            return database()->query($query);
        }

        static function create_vehicle(
            string | null $name,
            string | null $model,
            string | null $manufacturer,
            int | null $cost_in_credits,
            int | null $length,
            int | null $max_atmosphering_speed,
            int | null $crew,
            int | null $passengers,
            int | null $cargo_capacity,
            string | null $consumables,
            string | null $vehicle_class,
        ): bool{
            $table = self::$table;
            

            $query = "INSERT INTO $table (name, model, manufacturer, cost_in_credits, length, max_atmosphering_speed, crew, passengers, cargo_capacity, consumables, vehicle_class) VALUES ('$name', '$model', '$manufacturer', $cost_in_credits, $length, $max_atmosphering_speed, $crew, $passengers, $cargo_capacity, '$consumables', '$vehicle_class')";
            return database()->query($query);
        }
    }