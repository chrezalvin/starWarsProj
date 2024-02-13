<?php

    require_once '../Model/Planet.php';

    class PlanetView extends Planet{
        private bool $m_isDeletable;

        public static function get_planet_view_from_query(array $row): PlanetView{
            $planet = Planet::get_planet_from_query($row);
            $isDeletable = $row['deletable'];

            return new PlanetView(
                $planet->getId(),
                $planet->getName(),
                $planet->getRotationPeriod(),
                $planet->getOrbitalPeriod(),
                $planet->getDiameter(),
                $planet->getClimate(),
                $planet->getGravity(),
                $planet->getTerrain(),
                $planet->getSurfaceWater(),
                $planet->getPopulation(),
                $isDeletable
            );
        }

        function __construct(
            int $id,
            string $name,
            int | null $rotation_period,
            int | null $orbital_period,
            int | null $diameter,
            string | null $climate,
            string | null $gravity,
            string | null $terrain,
            int | null $surface_water,
            int | null $population,
            bool $isDeletable
        )
        {
            parent::__construct($id, $name, $rotation_period, $orbital_period, $diameter, $climate, $gravity, $terrain, $surface_water, $population);
            $this->m_isDeletable = $isDeletable;
        }

        // getter
        function isDeletable(){
            return $this->m_isDeletable;
        }
    }