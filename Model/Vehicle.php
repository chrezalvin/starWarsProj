<?php
    class Vehicle{
        private int | null $m_id;
        private string | null $m_name;
        private string | null $m_model;
        private string | null $m_manufacturer;
        private int | null $m_cost_in_credits;
        private float | null $m_length;
        private int | null $m_max_atmosphering_speed;
        private int | null $m_crew;
        private int | null $m_passengers;
        private int | null $m_cargo_capacity;
        private string | null $m_consumables;
        private string | null $m_vehicle_class;

        public static function get_vehicle_from_query(array $data){
            return new Vehicle(
                $data['id'],
                $data['name'],
                $data['model'],
                $data['manufacturer'],
                $data['cost_in_credits'],
                $data['length'],
                $data['max_atmosphering_speed'],
                $data['crew'],
                $data['passengers'],
                $data['cargo_capacity'],
                $data['consumables'],
                $data['vehicle_class']
            );
        }

        public function __construct(
            int | null $id,
            string | null $name,
            string | null $model,
            string | null $manufacturer,
            int | null $cost_in_credits,
            float | null $length,
            int | null $max_atmosphering_speed,
            int | null $crew,
            int | null $passengers,
            int | null $cargo_capacity,
            string | null $consumables,
            string | null $vehicle_class
        ){
            $this->m_id = $id;
            $this->m_name = $name;
            $this->m_model = $model;
            $this->m_manufacturer = $manufacturer;
            $this->m_cost_in_credits = $cost_in_credits;
            $this->m_length = $length;
            $this->m_max_atmosphering_speed = $max_atmosphering_speed;
            $this->m_crew = $crew;
            $this->m_passengers = $passengers;
            $this->m_cargo_capacity = $cargo_capacity;
            $this->m_consumables = $consumables;
            $this->m_vehicle_class = $vehicle_class;
        }

        // getters
        public function getId(): int | null{
            return $this->m_id;
        }

        public function getName(): string | null{
            return $this->m_name;
        }

        public function getModel(): string | null{
            return $this->m_model;
        }

        public function getManufacturer(): string | null{
            return $this->m_manufacturer;
        }

        public function getCostInCredits(): int | null{
            return $this->m_cost_in_credits;
        }

        public function getLength(): float | null{
            return $this->m_length;
        }

        public function getMaxAtmospheringSpeed(): int | null{
            return $this->m_max_atmosphering_speed;
        }

        public function getCrew(): int | null{
            return $this->m_crew;
        }

        public function getPassengers(): int | null{
            return $this->m_passengers;
        }

        public function getCargoCapacity(): int | null{
            return $this->m_cargo_capacity;
        }

        public function getConsumables(): string | null{
            return $this->m_consumables;
        }

        public function getVehicleClass(): string | null{
            return $this->m_vehicle_class;
        }
    }