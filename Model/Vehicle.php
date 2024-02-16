<?php
    class Vehicle{
        private int $m_id;
        private string $m_name;
        private ?string $m_model;
        private ?string $m_manufacturer;
        private ?int $m_cost_in_credits;
        private ?float $m_length;
        private ?int $m_max_atmosphering_speed;
        private ?int $m_crew;
        private ?int $m_passengers;
        private ?int $m_cargo_capacity;
        private ?string $m_consumables;
        private ?string $m_vehicle_class;
        private ?string $m_img_url;

        public static function get_vehicle_from_query(array $data){
            $id = $data['id'] ?? 0;
            $name = $data['name'] ?? '';
            $model = $data['model'] ?? null;
            $manufacturer = $data['manufacturer'] ?? null;
            $cost_in_credits = intval($data['cost_in_credits']) == 0 ? null : intval($data['cost_in_credits']);
            $length = floatval($data['length']) == 0 ? null : floatval($data['length']);
            $max_atmosphering_speed = intval($data['max_atmosphering_speed']) == 0 ? null : intval($data['max_atmosphering_speed']);
            $crew = intval($data['crew']) == 0 ? null : intval($data['crew']);
            $passengers = intval($data['passengers']) == 0 ? null : intval($data['passengers']);
            $cargo_capacity = intval($data['cargo_capacity']) == 0 ? null : intval($data['cargo_capacity']);
            $consumables = $data['consumables'] ?? null;
            $vehicle_class = $data['vehicle_class'] ?? null;
            $img_url = $data['img_url'] ?? null;

            return new Vehicle(
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

        public function __construct(
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
            $this->m_img_url = $img_url;
        }

        // getters
        public function getId(): ?int{
            return $this->m_id;
        }

        public function getName(): ?string{
            return $this->m_name;
        }

        public function getModel(): ?string{
            return $this->m_model;
        }

        public function getManufacturer(): ?string{
            return $this->m_manufacturer;
        }

        public function getCostInCredits(): ?int{
            return $this->m_cost_in_credits;
        }

        public function getLength(): ?float{
            return $this->m_length;
        }

        public function getMaxAtmospheringSpeed(): ?int{
            return $this->m_max_atmosphering_speed;
        }

        public function getCrew(): ?int{
            return $this->m_crew;
        }

        public function getPassengers(): ?int{
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

        public function getImgUrl(): string | null{
            return $this->m_img_url;
        }
    }