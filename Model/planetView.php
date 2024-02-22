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

        static function create_form(PlanetView $planetView = null){
            $id = $planetView?->getId();
            $name = $planetView?->getName() ?? "";
            $rotation_period = $planetView?->getRotationPeriod() ?? "";
            $orbital_period = $planetView?->getOrbitalPeriod() ?? "";
            $diameter = $planetView?->getDiameter() ?? "";
            $climate = $planetView?->getClimate() ?? "";
            $gravity = $planetView?->getGravity() ?? "";
            $terrain = $planetView?->getTerrain() ?? "";
            $surface_water = $planetView?->getSurfaceWater() ?? "";
            $population = $planetView?->getPopulation() ?? "";

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
                    <label for="rotation_period">Rotation Period</label>
                    <input type="number" name="rotation_period" id="rotation_period" class="form-control" min="0" value="<?= $rotation_period ?>"/>
                </div>
                
                <div class="form-group">
                    <label for="orbital_period">Orbital Period</label>
                    <input type="number" name="orbital_period" id="orbital_period" min="0" class="form-control" value="<?= $orbital_period ?>"/>
                </div>

                <div class="form-group">
                    <label for="diameter">Diameter</label>
                    <input type="number" name="diameter" id="diameter" class="form-control" min="0" value="<?= $diameter ?>"/>
                </div>

                <div class="form-group">
                    <label for="climate">Climate</label>
                    <input type="text" name="climate" id="climate" class="form-control" value="<?= $climate ?>"/>
                </div>

                <div class="form-group">
                    <label for="gravity">Gravity</label>
                    <input type="text" name="gravity" id="gravity" class="form-control" value="<?= $gravity ?>"/>
                </div>

                <div class="form-group">
                    <label for="terrain">Terrain</label>
                    <input type="text" name="terrain" id="terrain" class="form-control" value="<?= $terrain ?>"/>
                </div>

                <div class="form-group">
                    <label for="surface_water">Surface Water</label>
                    <input type="number" name="surface_water" id="surface_water" class="form-control" value="<?= $surface_water ?>"/>
                </div>

                <div class="form-group">
                    <label for="population">Population</label>
                    <input type="number" name="population" id="population" min="0" class="form-control" value="<?= $population ?>"/>
                </div>
            <?php 
            
            return ob_get_clean();

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