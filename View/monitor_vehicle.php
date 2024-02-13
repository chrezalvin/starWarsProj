<?php require_once '../Controller/monitor_vehicle.php' ?>

<?php $top_title = "Monitor Vehicles"; include '../include/top.php' ?>
<body>
        <!-- prompt for error -->
        <?php if($error != null): ?>
            <div class="d-flex justify-content-center">
                <div class="alert alert-danger alert-dismissible w-50 my-1">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <!-- Add Button -->
        <div class="position-absolute end-0 m-2">
            <button 
                class="btn btn-outline-success fw-bold text-warning"
                data-bs-toggle="modal"
                data-bs-target="#addvehicle"
                >
                Add a new Vehicle
            </button>
        </div>

        <!-- Add Button Modal -->
        <div class="modal" id="addvehicle" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Vehicle</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="./add_vehicle.php" method="post">
                        <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="" required/>
                            </div>

                            <div class="form-group">
                                <label for="model">Model</label>
                                <input type="text" name="model" id="model" class="form-control" value=""/>
                            </div>

                            <div class="form-group">
                                <label for="manufacturer">Manufacturer</label>
                                <input type="text" name="manufacturer" id="manufacturer" class="form-control" value=""/>
                            </div>

                            <div class="form-group">
                                <label for="cost_in_credits">Cost in Credits</label>
                                <input type="number" name="cost_in_credits" id="cost_in_credits" class="form-control" value="" />
                            </div>

                            <div class="form-group">
                                <label for="length">Length</label>
                                <input type="number" name="length" id="length" step="0.1" class="form-control" value=""/>
                            </div>

                            <div class="form-group">
                                <label for="max_atmosphering_speed">Max Atmosphering Speed</label>
                                <input type="number" name="max_atmosphering_speed" id="max_atmosphering_speed" class="form-control" value=""/>
                            </div>

                            <div class="form-group">
                                <label for="crew">Crew</label>
                                <input type="number" name="crew" id="crew" class="form-control" value=""/>
                            </div>

                            <div class="form-group">
                                <label for="passengers">Passengers</label>
                                <input type="number" name="passengers" id="passengers" class="form-control" value=""/>
                            </div>

                            <div class="form-group">
                                <label for="cargo_capacity">Cargo Capacity</label>
                                <input type="number" name="cargo_capacity" id="cargo_capacity" class="form-control" value=""/>
                            </div>

                            <div class="form-group">
                                <label for="consumables">Consumables</label>
                                <input type="text" name="consumables" id="consumables" class="form-control" value=""/>
                            </div>

                            <div class="form-group">
                                <label for="vehicle_class">Vehicle Class</label>
                                <input type="text" name="vehicle_class" id="vehicle_class" class="form-control" value=""/>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-primary" type="submit">Create</button>
                                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <div class="d-flex justify-content-center align-items-center gap-2">
        <a href="./monitor_planet.php" class="h-100 link-underline link-underline-opacity-0">Planets</a>
        <h1 class="text-center">Vehicles</h1>
    </div>
    <div class="d-flex justify-content-center">
        <form action="" class="w-50 d-flex justify-content-center gap-2">
            <div class="input-group">
                <input
                    type="text"
                    name="search"
                    class="form-control text-center"
                    placeholder="Search vehicle name here"
                    value="<?= $search ?? "" ?>"
                />
                <button class="btn btn-outline-primary">Search</button>
            </div>
        </form>
    </div>
    <!-- table -->
    <table class="table w-100 px-4">
        <tr class="text-center">
            <th>Name</th>
            <th>Model</th>
            <th>Manufacturer</th>
            <th>Cost</th>
            <th>Length</th>
            <th>Max Speed</th>
            <th>Crew</th>
            <th>Passengers</th>
            <th>Cargo</th>
            <th>Consumables</th>
            <th>Class</th>
            <th>Action</th>
        </tr>
        <?php foreach($vehicles as $vehicle): ?>
            <!-- Delete modal for each vehicle -->
            <div class="modal" id="modal<?= $vehicle->getId() ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirmation</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete <?= $vehicle->getName() ?>?</p>
                                <p>This data cannot be recovered afterwards</p>
                            </div>
                            <div class="modal-footer">
                                <form method="post" action="./delete_vehicle.php">
                                    <input type="hidden" name="deleteId" value="<?= $vehicle->getId() ?>" />
                                    <button type="submit" class="btn btn-danger">Yes, Delete It</button>
                                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Edit modal for each vehicle -->
                <div class="modal" id="modalEdit<?= $vehicle->getId() ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit vehicle</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="./edit_vehicle.php" method="post">
                                <div class="modal-body">

                                    <input type="hidden" name="id" value="<?= $vehicle->getId() ?>" />

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

            <tr class="text-center align-middle">
                <td><?= $vehicle->getName() ?></td>
                <td><?= $vehicle->getModel() ?></td>
                <td><?= $vehicle->getManufacturer() ?? "unknown" ?></td>
                <td><?= $vehicle->getCostInCredits() ?? "n/a" ?></td>
                <td><?= $vehicle->getLength() ?? "n/a" ?></td>
                <td><?= $vehicle->getMaxAtmospheringSpeed() ?? "n/a" ?></td>
                <td><?= $vehicle->getCrew() ?? "n/a" ?></td>
                <td><?= $vehicle->getPassengers() ?? "n/a" ?></td>
                <td><?= $vehicle->getCargoCapacity() ?? "n/a" ?></td>
                <td><?= $vehicle->getConsumables() ?? "n/a" ?></td>
                <td><?= $vehicle->getVehicleClass() ?? "unknown" ?></td>
                <td class="d-flex justify-content-center gap-1">
                    <button
                        type="button"
                        data-bs-toggle="modal" 
                        data-bs-target="#modalEdit<?= $vehicle->getId() ?>"
                        class="btn btn-warning"
                    >Edit</button>
                    <button
                        type="button"
                        data-bs-toggle="modal" 
                        data-bs-target="#modal<?= $vehicle->getId() ?>"
                        class="btn btn-danger"
                    >
                        Delete
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>