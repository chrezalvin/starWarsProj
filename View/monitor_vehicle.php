<?php require_once '../Controller/monitor_planet.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include '../assets/jquery.php' ?>
    <?php include '../assets/bootstrap.php' ?>

    <title>Monitor Planet</title>
</head>
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
                    <form action="./edit_planet.php" method="post">
                        <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="" required/>
                        </div>

                        <div class="form-group">
                            <label for="rotation_period">Rotation Period</label>
                            <input type="number" name="rotation_period" id="rotation_period" class="form-control"/>
                        </div>
                        
                        <div class="form-group">
                            <label for="orbital_period">Orbital Period</label>
                            <input type="number" name="orbital_period" id="orbital_period" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="diameter">Diameter</label>
                            <input type="number" name="diameter" id="diameter" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="climate">Climate</label>
                            <input type="text" name="climate" id="climate" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="gravity">Gravity</label>
                            <input type="text" name="gravity" id="gravity" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="terrain">Terrain</label>
                            <input type="text" name="terrain" id="terrain" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label for="surface_water">Surface Water</label>
                            <input type="number" name="surface_water" id="surface_water" class="form-control" value=""/>
                        </div>

                        <div class="form-group">
                            <label for="population">Population</label>
                            <input type="number" name="population" id="population" class="form-control" value=""/>
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


    <div class="d-flex justify-content-center">
        <a href="./monitor_people.php" class="h-100 link-underline link-underline-opacity-0">Characters</a>
        <h1 class="text-center">Planets</h1>
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
                <button class="btn btn-outline-primary">Search</button>
            </div>
        </form>
    </div>
    <!-- table -->
    <table class="table w-100 px-4">
        <tr class="text-center">
            <th>Name</th>
            <th>Rotation Period</th>
            <th>Orbital Period</th>
            <th>Diameter</th>
            <th>Climate</th>
            <th>Gravity</th>
            <th>Terrain</th>
            <th>Surface Water</th>
            <th>Population</th>
            <th>Action</th>
        </tr>
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
                            <form action="./edit_planet.php" method="post">
                                <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $planet->getId() ?>" />
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
                                    <input type="text" name="climate" id="climate" class="form-control" value="<?= $planet->getClimate() ?? "n/a" ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="gravity">Gravity</label>
                                    <input type="text" name="gravity" id="gravity" class="form-control" value="<?= $planet->getGravity() ?? "n/a" ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="terrain">Terrain</label>
                                    <input type="text" name="terrain" id="terrain" class="form-control" value="<?= $planet->getTerrain() ?? "n/a" ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="surface_water">Surface Water</label>
                                    <input type="number" name="surface_water" id="surface_water" class="form-control" value="<?= $planet->getSurfaceWater() ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="population">Population</label>
                                    <input type="number" name="population" id="population" class="form-control" value="<?= $planet->getPopulation() ?>"/>
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
                <td><?= $planet->getName() ?></td>
                <td><?= $planet->getRotationPeriod()  ?? "n/a" ?></td>
                <td><?= $planet->getOrbitalPeriod() ?? "n/a" ?></td>
                <td><?= $planet->getDiameter() ?? "n/a" ?></td>
                <td><?= $planet->getClimate() ?? "n/a" ?></td>
                <td><?= $planet->getGravity() ?? "n/a" ?></td>
                <td><?= $planet->getTerrain() ?? "n/a" ?></td>
                <td><?= $planet->getSurfaceWater() ?? "n/a" ?></td>
                <td><?= $planet->getPopulation() ?? "n/a" ?></td>
                <td class="d-flex justify-content-center gap-1">
                    <button
                        type="button"
                        data-bs-toggle="modal" 
                        data-bs-target="#modalEdit<?= $planet->getId() ?>"
                        class="btn btn-warning"
                    >Edit</button>
                    <button
                        type="button"
                        data-bs-toggle="modal" 
                        data-bs-target="#modal<?= $planet->getId() ?>"
                        class="btn btn-danger <?= $planet->isDeletable() ? "disabled": "" ?>"
                    >
                        Delete
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>