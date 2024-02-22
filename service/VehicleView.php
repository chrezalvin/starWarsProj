<?php
    require_once('../include/database.php');
    require_once('../Model/Vehicle.php');

    class VehicleViewDatabase{
        private static $table = "vehicle_view";

        private function __construct(){}

        static function get_view(){
            $table = self::$table;

            $stmt = pdo()->query("SELECT * FROM `$table` LIMIT 20");
            $data = $stmt->fetchAll();

            $vehicles = [];
            foreach($data as $row)
                $vehicles[] = VehicleView::get_vehicleview_from_query($row);

            return $vehicles;
        }
    }