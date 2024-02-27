<?php
    require_once('../include/database.php');
    require_once('../Model/VehicleView.php');

    class VehicleViewDatabase{
        private static $table = "vehicle_view";

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
            $vehicles = array_map(fn($row) => VehicleView::get_vehicleview_from_query($row), $data);

            return $vehicles;
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

            $stmt = pdo()->query("SELECT * FROM `$table` LIMIT 20");
            $data = $stmt->fetchAll();
            
            return json_encode($data);
        }

        /**
         * @param VehicleView[] $vehicleView
         */
        static function generateLabeledElements($vehicleView){
            return [
                "Name" => array_map(fn(VehicleView $vehicle) => $vehicle->getName(), $vehicleView),
                "Model" => array_map(fn(VehicleView $vehicle) => $vehicle->getModel(), $vehicleView),
                "Manufacturer" => array_map(fn(VehicleView $vehicle) => $vehicle->getManufacturer(), $vehicleView),
                "Cost in Credits" => array_map(fn(VehicleView $vehicle) => $vehicle->getCostInCredits(), $vehicleView),
                "Length" => array_map(fn(VehicleView $vehicle) => $vehicle->getLength(), $vehicleView),
                "Max Atmosphering Speed" => array_map(fn(VehicleView $vehicle) => $vehicle->getMaxAtmospheringSpeed(), $vehicleView),
                "Crew" => array_map(fn(VehicleView $vehicle) => $vehicle->getCrew(), $vehicleView),
                "Passengers" => array_map(fn(VehicleView $vehicle) => $vehicle->getPassengers(), $vehicleView),
                "Cargo Capacity" => array_map(fn(VehicleView $vehicle) => $vehicle->getCargoCapacity(), $vehicleView),
                "Consumables" => array_map(fn(VehicleView $vehicle) => $vehicle->getConsumables(), $vehicleView),
                "Vehicle Class" => array_map(fn(VehicleView $vehicle) => $vehicle->getVehicleClass(), $vehicleView),
            ];
        }
    }