<?php
    require_once('../Model/Vehicle.php');
    require_once('../Model/VehicleView.php');

    class VehicleView extends Vehicle{
        public static function get_vehicleview_from_query(array $query){
            $vehicle = parent::get_vehicle_from_query($query);

            return new VehicleView(
                $vehicle->getId(),
                $vehicle->getName(),
                $vehicle->getModel(),
                $vehicle->getManufacturer(),
                $vehicle->getCostInCredits(),
                $vehicle->getLength(),
                $vehicle->getMaxAtmospheringSpeed(),
                $vehicle->getCrew(),
                $vehicle->getPassengers(),
                $vehicle->getCargoCapacity(),
                $vehicle->getConsumables(),
                $vehicle->getVehicleClass(),
                $vehicle->getImgUrl()
            );
        }
    
        function __construct(
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
        )
        {
            parent::__construct(
                $id,
                $name,
                $model,
                $manufacturer,
                $cost_in_credits,
                $length,
                $max_atmosphering_speed,
                $crew,
                $passengers,
                $cargo_capacity,
                $consumables,
                $vehicle_class,
                $img_url
            );
        }
    }