<?php require_once '../Controller/monitor_vehicle.php' ?>
<?php require_once('../include/top.php'); ?>
<?php require_once('../include/table.php'); ?>

<?= top("Monitor Vehicles") ?>
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
        <div class="position-absolute start-0 m-2">
            <a href="./api.php">
                <button class="btn btn-primary fw-bold px-5"> API </button>
            </a>
        </div>

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
                    <form 
                        action="./add_vehicle.php" 
                        method="post"
                        enctype="multipart/form-data"
                    >
                        <div class="modal-body">
                            <?= Vehicle::create_form() ?>
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
                            <form 
                                action="./edit_vehicle.php" 
                                method="post"
                                enctype="multipart/form-data"
                            >
                                <div class="modal-body">
                                    <?= Vehicle::create_form($vehicle) ?>
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

    <?= 
        TableElement::createTable(
            tableElements:[
                new TableElement("Name", array_map(function($vehicle){
                    ob_start(); 
                ?>
                    <?php if($vehicle->getImgUrl() !== null): ?>
                        <img 
                            src="../public/vehicle/<?= $vehicle->getImgUrl() ?>" 
                            class="img-fluid object-fit-cover"
                            width="60"
                            height="80"
                            alt="<?= $vehicle->getName() ?>'s image" 
                        />
                    <?php endif; ?>
                    <?= $vehicle->getName() ?>
                    <?php
                        return ob_get_clean();
                }, $vehicles), "d-flex justify-content-center flex-column align-items-center"),
                new TableElement("Model", array_map(fn($vehicle) => $vehicle->getModel(), $vehicles)),
                new TableElement("Manufacturer", array_map(fn($vehicle) => $vehicle->getManufacturer(), $vehicles)),
                new TableElement("Cost", array_map(fn($vehicle) => $vehicle->getCostInCredits(), $vehicles)),
                new TableElement("Length", array_map(fn($vehicle) => $vehicle->getLength(), $vehicles)),
                new TableElement("Max Speed", array_map(fn($vehicle) => $vehicle->getMaxAtmospheringSpeed(), $vehicles)),
                new TableElement("Crew", array_map(fn($vehicle) => $vehicle->getCrew(), $vehicles)),
                new TableElement("Passengers", array_map(fn($vehicle) => $vehicle->getPassengers(), $vehicles)),
                new TableElement("Cargo", array_map(fn($vehicle) => $vehicle->getCargoCapacity(), $vehicles)),
                new TableElement("Consumables", array_map(fn($vehicle) => $vehicle->getConsumables(), $vehicles)),
                new TableElement("Class", array_map(fn($vehicle) => $vehicle->getVehicleClass(), $vehicles)),
                new TableElement("Action", array_map(function ($vehicle) {
                    ob_start(); 
                ?>
                    <div class='d-flex justify-content-center flex-column gap-1'>
                        <button
                            type='button'
                            data-bs-toggle='modal'
                            data-bs-target='#modalEdit<?= $vehicle->getId() ?>'
                            class='btn btn-warning'
                        >Edit</button>
                        <button
                            type='button'
                            data-bs-toggle='modal'
                            data-bs-target='#modal<?= $vehicle->getId() ?>'
                            class='btn btn-danger'
                        >
                            Delete
                        </button>
                    <?php 
                        return ob_get_clean();
                }, $vehicles)
                )
            ],
            tableClass: "table w-100 px-4",
            theadClass: "text-center",
            tbodyClass: "text-center align-middle"
        )
    ?>

</body>
</html>