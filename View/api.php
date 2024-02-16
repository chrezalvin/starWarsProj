<?php require_once('../Controller/api.php'); ?>

<?php $top_title = "SWAPI"; include('../include/top.php'); ?>
<body class="min-vh-100 mb-4">
    <img 
        src="../assets/Star_wars2.svg" 
        class="img-fluid position-fixed top-50 start-50 translate-middle z-n1"
        style="opacity: 0.1;"
        alt=""
    >

        <!-- Add Button -->
    <div class="position-absolute end-0 m-2">
        <a href="./monitor_people.php">
            <button class="btn btn-outline-success fw-bold text-warning"> Back to Database </button>
        </a>
    </div>

    <div class="d-flex justify-content-center">
        <h1 class="px-2 border border-top-0 border-start-0 border-end-0 border-warning border-4">
            SWAPI
        </h1>
    </div>

    <div class="d-flex justify-content-center my-2">
        <h2 class="px-2 border border-top-0 border-start-0 border-end-0 border-warning border-4">
            People
        </h2>
    </div>

    <div class="container-fluid">
        <div class="row gx-3 gy-1 px-2">
            <?php foreach($people as $idx => $person): ?>
                <?php
                    $disabled = false;
                    foreach($db_people as $db_person){
                        if(strtolower($person->getName()) == strtolower($db_person->getName())){
                            $disabled = true;
                            break;
                        }
                    }    
                ?>
                <div class="col-3 d-flex border border-2 rounded-2 px-2 py-1 gap-2 shadow">
                    <div class="flex-grow-1">
                        <h4><?= $person->getName() ?></h4>
                    </div>
                    <div>
                        <button
                            class="btn btn-success <?= $disabled ? "disabled": "" ?>"
                            data-bs-toggle="modal"
                            data-bs-target="#modalPeople<?= $idx ?>"
                        >
                            Add
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="d-flex justify-content-center my-2">
        <h2 class="px-2 border border-top-0 border-start-0 border-end-0 border-warning border-4">
            Planets
        </h2>
    </div>

    <div class="container-fluid">
        <div class="row gx-3 gy-1 px-2">
            <?php foreach($planets as $idx => $planet): ?>
                <?php
                    $disabled = false;
                    foreach($db_planets as $db_planet){
                        if(strtolower($planet->getName()) == strtolower($db_planet->getName())){
                            $disabled = true;
                            break;
                        }
                    }    
                ?>
                <div class="col-3 d-flex border border-2 rounded-2 px-2 py-1 gap-2 shadow">
                    <div class="flex-grow-1">
                        <h4><?= $planet->getName() ?></h4>
                    </div>
                    <div>
                        <button
                            class="btn btn-success <?= $disabled ? "disabled": "" ?>"
                            data-bs-toggle="modal"
                            data-bs-target="#modalPlanet<?= $idx ?>"
                        >
                            Add
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="d-flex justify-content-center my-2">
        <h2 class="px-2 border border-top-0 border-start-0 border-end-0 border-warning border-4">
            Vehicles
        </h2>
    </div>

    <div class="container-fluid">
        <div class="row gx-3 gy-1 px-2">
            <?php foreach($vehicles as $idx => $vehicle): ?>
                <?php
                    $disabled = false;
                    foreach($db_vehicles as $db_vehicle){
                        if(strtolower($vehicle->getName()) == strtolower($db_vehicle->getName())){
                            $disabled = true;
                            break;
                        }
                    }    
                ?>
                <div class="col-3 d-flex border border-2 rounded-2 px-2 py-1 gap-2 shadow">
                    <div class="flex-grow-1">
                        <h4><?= $vehicle->getName() ?></h4>
                    </div>
                    <div>
                        <button
                            class="btn btn-success <?= $disabled ? "disabled": "" ?>"
                            data-bs-toggle="modal"
                            data-bs-target="#modalVehicle<?= $idx ?>"
                        >
                            Add
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php foreach($people as $idx => $person): ?>
        <div class="modal" id="modalPeople<?= $idx ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add People</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="./add_people.php" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                <div class="form-group">
                                    <label for="image">Image</label>
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
                                    <input type="text" name="name" id="name" class="form-control" placeholder="e.g: Anakin Skywalker" value="<?= $person->getName() ?>" required />
                                </div>
                                <div class="form-group">
                                    <label for="height">Height</label>
                                    <input type="number" name="height" id="height" class="form-control" value="<?= $person->getHeight() ?>" min="0"/>
                                </div>
                                <div class="form-group">
                                    <label for="mass">Mass</label>
                                    <input type="number" name="mass" id="mass" class="form-control" value="<?= $person->getMass() ?>" min="0"/>
                                </div>
                                <div class="form-group">
                                    <label for="hair_color">Hair Color</label>
                                    <input type="text" name="hair_color" id="hair_color" class="form-control" value="<?= $person->getHairColor() ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="skin_color">Skin Color</label>
                                    <input type="text" name="skin_color" id="skin_color" class="form-control" value="<?= $person->getSkinColor() ?>" />
                                </div>
                                <div class="form-group">
                                    <label for="eye_color">Eye Color</label>
                                    <input type="text" name="eye_color" id="eye_color" class="form-control" value="<?= $person->getEyeColor() ?>" />
                                </div>
                                <div class="form-group">
                                                <label for="birth_year">Birth Year</label>
                                                <div class="input-group">
                                                    <input type="number" name="birth_year" id="birth_year" class="form-control" value="<?= preg_match("/(\d+)/", $person->getBirthYear(), $matches) ? $matches[0] : "0";  ?>" min="0" />
                                                    <div class="input-group-append">
                                                        <select name="birth_year_indicator" id="birthyear" class="form-select fw-bold">
                                                            <?php
                                                                $matches;
                                                                preg_match("/(BBY|ABY)/", $person->getBirthYear(), $matches);
                                                                $matches = $matches[0];
                                                            ?>
                                                            <option value="BBY" <?= $matches === "BBY" ? "selected": '' ?>>BBY</option>
                                                            <option value="ABY" <?= $matches === "ABY" ? "selected": '' ?>>ABY</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <input type="text" name="gender" id="gender" class="form-control" value="<?= $person->getGender() ?>" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-success" type="submit">Create</button>
                                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
    <?php endforeach; ?>


    <?php foreach($planets as $idx => $planet): ?>

        <div class="modal" id="modalPlanet<?= $idx ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Planet</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="./add_planet.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
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
                            <input type="text" name="name" id="name" class="form-control" value="<?= $planet->getName() ?>" required/>
                        </div>

                        <div class="form-group">
                            <label for="rotation_period">Rotation Period</label>
                            <input type="number" name="rotation_period" id="rotation_period" class="form-control" value="<?= $planet->getRotationPeriod() ?>"/>
                        </div>
                        
                        <div class="form-group">
                            <label for="orbital_period">Orbital Period</label>
                            <input type="number" name="orbital_period" id="orbital_period" class="form-control" value="<?= $planet->getOrbitalPeriod() ?>"/>
                        </div>

                        <div class="form-group">
                            <label for="diameter">Diameter</label>
                            <input type="number" name="diameter" id="diameter" class="form-control" value="<?= $planet->getDiameter() ?>"/>
                        </div>

                        <div class="form-group">
                            <label for="climate">Climate</label>
                            <input type="text" name="climate" id="climate" class="form-control" value="<?= $planet->getClimate() ?>"/>
                        </div>

                        <div class="form-group">
                            <label for="gravity">Gravity</label>
                            <input type="text" name="gravity" id="gravity" class="form-control" value="<?= $planet->getGravity() ?>"/>
                        </div>

                        <div class="form-group">
                            <label for="terrain">Terrain</label>
                            <input type="text" name="terrain" id="terrain" class="form-control" value="<?= $planet->getTerrain() ?>"/>
                        </div>

                        <div class="form-group">
                            <label for="surface_water">Surface Water</label>
                            <input type="number" name="surface_water" id="surface_water" class="form-control" value="<?= $planet->getSurfaceWater() ?>"/>
                        </div>

                        <div class="form-group">
                            <label for="population">Population</label>
                            <input type="number" name="population" id="population" class="form-control" value="<?= $planet->getPopulation() ?>"/>
                        </div>
                        </div>

                        <div class="modal-footer">
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-primary" type="submit">Update</button>
                                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

    <?php foreach($vehicles as $idx => $vehicle): ?>

        <div class="modal" id="modalVehicle<?= $idx ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit vehicle</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form 
                                action="./add_vehicle.php" 
                                method="post"
                                enctype="multipart/form-data"
                            >
                                <div class="modal-body">

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
                                        <input type="text" name="name" id="name" class="form-control" value="<?= $vehicle->getName() ?>" required/>
                                    </div>

                                    <div class="form-group">
                                        <label for="model">Model</label>
                                        <input type="text" name="model" id="model" class="form-control" value="<?= $vehicle->getModel() ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label for="manufacturer">Manufacturer</label>
                                        <input type="text" name="manufacturer" id="manufacturer" class="form-control" value="<?= $vehicle->getManufacturer() ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label for="cost_in_credits">Cost in Credits</label>
                                        <input type="number" name="cost_in_credits" id="cost_in_credits" class="form-control" value="<?= $vehicle->getCostInCredits() ?>"/>
                                    </div>

                                    <div class="form-group">
                                        <label for="length">Length</label>
                                        <input type="number" step="0.1" name="length" id="length" class="form-control" value="<?= $vehicle->getLength() ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label for="max_atmosphering_speed">Max Atmosphering Speed</label>
                                        <input type="number" name="max_atmosphering_speed" id="max_atmosphering_speed" class="form-control" value="<?= $vehicle->getMaxAtmospheringSpeed() ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label for="crew">Crew</label>
                                        <input type="number" name="crew" id="crew" class="form-control" value="<?= $vehicle->getCrew() ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label for="passengers">Passengers</label>
                                        <input type="number" name="passengers" id="passengers" class="form-control" value="<?= $vehicle->getPassengers() ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label for="cargo_capacity">Cargo Capacity</label>
                                        <input type="number" name="cargo_capacity" id="cargo_capacity" class="form-control" value="<?= $vehicle->getCargoCapacity() ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label for="consumables">Consumables</label>
                                        <input type="text" name="consumables" id="consumables" class="form-control" value="<?= $vehicle->getConsumables() ?>" />
                                    </div>

                                    <div class="form-group">
                                        <label for="vehicle_class">Vehicle Class</label>
                                        <input type="text" name="vehicle_class" id="vehicle_class" class="form-control" value="<?= $vehicle->getVehicleClass() ?>" />
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-primary" type="submit">Update</button>
                                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

        <?php endforeach; ?>

</body>
</html>