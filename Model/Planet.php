<?php
    class Planet{
        private int $m_id;
        private string $m_name;
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
            $id = $queryData['id'] ?? 0;
            $name = $queryData['name'] ?? '';
            $rotation_period = $queryData['rotation_period'];
            $orbital_period = $queryData['orbital_period'];
            $diameter = $queryData['diameter'];
            $climate = $queryData['climate'];
            $gravity = $queryData['gravity'];
            $terrain = $queryData['terrain'];
            $surface_water = intval($queryData['surface_water']);
            $population = intval($queryData['population']);
            $img_url = $queryData['img_url'] ?? null;

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

        public function __construct(
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
            $this->m_id = $id;
            $this->m_name = $name;
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
        public function getId(){
            return $this->m_id;
        }

        public function getName(){
            return $this->m_name;
        }

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