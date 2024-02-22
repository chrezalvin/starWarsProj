<?php
    require_once('../Model/Base.php');
    require_once('../include/library.php');

    class Vehicle extends Base{
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

        public static function create_form(Vehicle $vehicle = null){
            $id = $vehicle?->getId();
            $name = $vehicle?->getName() ?? "";
            $model = $vehicle?->getModel() ?? "";
            $manufacturer = $vehicle?->getManufacturer() ?? "";
            $cost_in_credits = $vehicle?->getCostInCredits() ?? "";
            $length = $vehicle?->getLength() ?? "";
            $max_atmosphering_speed = $vehicle?->getMaxAtmospheringSpeed() ?? "";
            $crew = $vehicle?->getCrew() ?? "";
            $passengers = $vehicle?->getPassengers() ?? "";
            $cargo_capacity = $vehicle?->getCargoCapacity() ?? "";
            $consumables = $vehicle?->getConsumables() ?? "";
            $vehicle_class = $vehicle?->getVehicleClass() ?? "";

            ob_start(); ?>
                <?php if(!is_null($id)): ?>
                    <input type="hidden" name="id" value="<?= $id ?>" />
                <?php endif; ?>

                <div class="form-group">
                    <label for="image">Insert New Image</label>
                    <input 
                        type="file" 
                        name="photo"
                        accept=".png, .jpg, .jpeg"
                        id="image"
                        class="form-control" 
                        size="60"    
                    />
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?= $name ?>" required/>
                </div>

                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" name="model" id="model" class="form-control" value="<?= $model ?>" />
                </div>

                <div class="form-group">
                    <label for="manufacturer">Manufacturer</label>
                    <input type="text" name="manufacturer" id="manufacturer" class="form-control" value="<?= $manufacturer ?>" />
                </div>

                <div class="form-group">
                    <label for="cost_in_credits">Cost in Credits</label>
                    <input type="number" name="cost_in_credits" id="cost_in_credits" class="form-control" value="<?= $cost_in_credits ?>"/>
                </div>

                <div class="form-group">
                    <label for="length">Length</label>
                    <input type="number" step="0.1" name="length" id="length" class="form-control" value="<?= $length ?>" />
                </div>

                <div class="form-group">
                    <label for="max_atmosphering_speed">Max Atmosphering Speed</label>
                    <input type="number" name="max_atmosphering_speed" id="max_atmosphering_speed" class="form-control" value="<?= $max_atmosphering_speed ?>" />
                </div>

                <div class="form-group">
                    <label for="crew">Crew</label>
                    <input type="number" name="crew" id="crew" class="form-control" value="<?= $crew ?>" />
                </div>

                <div class="form-group">
                    <label for="passengers">Passengers</label>
                    <input type="number" name="passengers" id="passengers" class="form-control" value="<?= $passengers ?>" />
                </div>

                <div class="form-group">
                    <label for="cargo_capacity">Cargo Capacity</label>
                    <input type="number" name="cargo_capacity" id="cargo_capacity" class="form-control" value="<?= $cargo_capacity ?>" />
                </div>

                <div class="form-group">
                    <label for="consumables">Consumables</label>
                    <input type="text" name="consumables" id="consumables" class="form-control" value="<?= $consumables ?>" />
                </div>

                <div class="form-group">
                    <label for="vehicle_class">Vehicle Class</label>
                    <input type="text" name="vehicle_class" id="vehicle_class" class="form-control" value="<?= $vehicle_class ?>" />
                </div>

            <?php 
                return ob_get_clean();
        }

        public static function get_vehicle_from_query(array $data){
            $id = sanitizeInputInt($data['id']);
            $name = sanitizeInputStr($data['name']);
            $model = sanitizeInputStr($data['model']);
            $manufacturer = sanitizeInputStr($data['manufacturer']);
            $cost_in_credits = sanitizeInputInt($data['cost_in_credits']);
            $length = floatval($data['length']) == 0 ? null : floatval($data['length']);
            $max_atmosphering_speed = sanitizeInputInt($data['max_atmosphering_speed']);
            $crew = sanitizeInputInt($data['crew']);
            $passengers = sanitizeInputInt($data['passengers']);
            $cargo_capacity = sanitizeInputInt($data['cargo_capacity']);
            $consumables = sanitizeInputStr($data['consumables']);
            $vehicle_class = sanitizeInputStr($data['vehicle_class']);
            $img_url = sanitizeInputStr($data['img_url']);

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

        protected function __construct(
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
            parent::__construct($id, $name);
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