<?php
    require_once('../Model/Base.php');
    require_once('../include/library.php');

    class Planet extends Base{
        private ?int $m_rotation_period;
        private ?int $m_orbital_period;
        private ?int $m_diameter;
        private ?string $m_climate;
        private ?string $m_gravity;
        private ?string $m_terrain;
        private ?int $m_surface_water;
        private ?int $m_population;
        private ?string $m_img_url;

        public static function get_planet_from_query(array $queryData): Planet{
            $id = sanitizeInputInt($queryData['id']) ?? 0;
            $name = sanitizeInputStr($queryData['name']);
            $rotation_period = sanitizeInputInt($queryData['rotation_period']);
            $orbital_period = sanitizeInputInt($queryData['orbital_period']);
            $diameter = sanitizeInputInt($queryData['diameter']);
            $climate = sanitizeInputStr($queryData['climate']);
            $gravity = sanitizeInputStr($queryData['gravity']);
            $terrain = sanitizeInputStr($queryData['terrain']);
            $surface_water = sanitizeInputInt($queryData['surface_water']);
            $population = sanitizeInputInt($queryData['population']);
            $img_url = sanitizeInputStr($queryData['img_url']);

            return new Planet(
                $id, 
                $name, 
                $rotation_period, 
                $orbital_period, 
                $diameter, 
                $climate, 
                $gravity, 
                $terrain, 
                $surface_water, 
                $population,
                $img_url
            );
        }

        protected function __construct(
            int $id,
            string $name,
            ?int $rotation_period,
            ?int $orbital_period,
            ?int $diameter,
            ?string $climate,
            ?string $gravity,
            ?string $terrain,
            ?int $surface_water,
            ?int $population,
            ?string $img_url
        ){
            parent::__construct($id, $name);
            $this->m_rotation_period = $rotation_period;
            $this->m_orbital_period = $orbital_period;
            $this->m_diameter = $diameter;
            $this->m_climate = $climate;
            $this->m_gravity = $gravity;
            $this->m_terrain = $terrain;
            $this->m_surface_water = $surface_water;
            $this->m_population = $population;
            $this->m_img_url = $img_url;
        }

        // getter
        public function getRotationPeriod(){
            return $this->m_rotation_period;
        }

        public function getOrbitalPeriod(){
            return $this->m_orbital_period;
        }

        public function getDiameter(){
            return $this->m_diameter;
        }

        public function getClimate(){
            return $this->m_climate;
        }

        public function getGravity(){
            return $this->m_gravity;
        }

        public function getTerrain(){
            return $this->m_terrain;
        }

        public function getSurfaceWater(){
            return $this->m_surface_water;
        }

        public function getPopulation(){
            return $this->m_population;
        }

        public function getImgUrl(){
            return $this->m_img_url;
        }
    }