<?php
    class Planet{
        private int $m_id;
        private string $m_name;
        private int | null $m_rotation_period;
        private int | null $m_orbital_period;
        private int | null $m_diameter;
        private string | null $m_climate;
        private string | null $m_gravity;
        private string | null $m_terrain;
        private int | null $m_surface_water;
        private int | null $m_population;

        public static function get_planet_from_query(array $queryData): Planet{
            $id = $queryData['id'];
            $name = $queryData['name'];
            $rotation_period = $queryData['rotation_period'];
            $orbital_period = $queryData['orbital_period'];
            $diameter = $queryData['diameter'];
            $climate = $queryData['climate'];
            $gravity = $queryData['gravity'];
            $terrain = $queryData['terrain'];
            $surface_water = $queryData['surface_water'];
            $population = $queryData['population'];

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
                $population
            );
        }

        public function __construct(
            int $id,
            string $name,
            int | null $rotation_period,
            int | null $orbital_period,
            int | null $diameter,
            string | null $climate,
            string | null $gravity,
            string | null $terrain,
            int | null $surface_water,
            int | null $population
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
    }