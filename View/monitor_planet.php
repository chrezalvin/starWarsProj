<?php require_once '../Controller/monitor_planet.php' ?>
<?php require_once('../include/top.php'); ?>
<?php require_once('../include/table.php'); ?>

<?= top("Monitor Planet") ?>
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
                data-bs-target="#addPlanet"
                >
                Add a new Planet
            </button>
        </div>

        <!-- Add Button Modal -->
        <div class="modal" id="addPlanet" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Planet</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form 
                        action="./add_planet.php" 
                        method="post"
                        enctype="multipart/form-data"
                    >
                        <div class="modal-body">
                            <?= PlanetView::create_form() ?>
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
        <a href="./monitor_people.php" class="h-100 link-underline link-underline-opacity-0">Characters</a>
        <h1 class="text-center">Planets</h1>
        <a href="./monitor_vehicle.php" class="h-100 link-underline link-underline-opacity-0">Vehicles</a>
    </div>
    <div class="d-flex justify-content-center">
        <form action="" class="w-50 d-flex justify-content-center gap-2">
            <div class="input-group">
                <input
                    type="text"
                    name="search"
                    class="form-control text-center"
                    placeholder="Search planet name here"
                    value="<?= $search ?? "" ?>"
                />
                <button class="btn btn-outline-primary">
                    <i class="bi-search"></i>
                </button>
            </div>
        </form>
    </div>


    <?php foreach($planets as $planet): ?>
            <!-- Delete modal for each planet -->
            <div class="modal" id="modal<?= $planet->getId() ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirmation</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete <?= $planet->getName() ?>?</p>
                                <p>This data cannot be recovered afterwards</p>
                            </div>
                            <div class="modal-footer">
                                <form method="post" action="./delete_planet.php">
                                    <input type="hidden" name="deleteId" value="<?= $planet->getId() ?>" />
                                    <button type="submit" class="btn btn-danger">Yes, Delete It</button>
                                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Edit modal for each planet -->
                <div class="modal" id="modalEdit<?= $planet->getId() ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Planet</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="./edit_planet.php" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <?= PlanetView::create_form($planet) ?>
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

    <!-- table -->
    <?=
        TableElement::createTable(
            tableElements: [
                new TableElement("Name", array_map(function($planet){ 
                    ob_start(); ?>
                    <div class="d-flex justify-content-center flex-column align-items-center">
                        <?php if($planet->getImgUrl() !== null): ?>
                            <img 
                                src="../public/planet/<?= $planet->getImgUrl() ?>" 
                                class="img-fluid object-fit-cover rounded-2"
                                width="60"
                                height="80"
                                alt="<?= $planet->getName() ?>'s image" 
                            />
                        <?php endif; ?>
                        <?= $planet->getName() ?>
                    <?php 
                        return ob_get_clean();
                }, $planets)),
                new TableElement("Rotation Period", array_map(function($planet){ return $planet->getRotationPeriod(); }, $planets)),
                new TableElement("Orbital Period", array_map(function($planet){ return $planet->getOrbitalPeriod(); }, $planets)),
                new TableElement("Diameter", array_map(function($planet){ return $planet->getDiameter(); }, $planets)),
                new TableElement("Climate", array_map(function($planet){ return $planet->getClimate(); }, $planets)),
                new TableElement("Gravity", array_map(function($planet){ return $planet->getGravity(); }, $planets)),
                new TableElement("Terrain", array_map(function($planet){ return $planet->getTerrain(); }, $planets)),
                new TableElement("Surface Water", array_map(function($planet){ return $planet->getSurfaceWater(); }, $planets)),
                new TableElement("Population", array_map(function($planet){ return $planet->getPopulation(); }, $planets)),
                new TableElement("Action", array_map(function($planet){
                    ob_start(); ?>
                    <div class="d-flex justify-content-center gap-1">
                        <button
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEdit<?= $planet->getId() ?>"
                            class="btn btn-warning"
                        >
                            <i class="bi-pen-fill text-dark"></i>
                        </button>
                        <button
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#modal<?= $planet->getId() ?>"
                            class="btn btn-danger <?= $planet->isDeletable() ? "disabled": "" ?>"
                        >
                            <i class="bi-trash3-fill text-dark"></i>
                        </button>
                    </div>
                    
                    <?php 
                        return ob_get_clean();
                }, $planets))
            ],
            tableClass: "table w-100 px-4",
            theadClass: "text-center",
            tbodyClass: "text-center align-middle"
        )
    ?>

</body>
</html>