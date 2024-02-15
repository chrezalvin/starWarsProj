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
                $planet->getImgUrl(),
                $isDeletable
            );
        }

        function __construct(
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
            ?string $img_url,
            bool $isDeletable
        )
        {
            parent::__construct($id, $name, $rotation_period, $orbital_period, $diameter, $climate, $gravity, $terrain, $surface_water, $population, $img_url);
            $this->m_isDeletable = $isDeletable;
        }

        // getter
        function isDeletable(): bool{
            return $this->m_isDeletable;
        }
    }