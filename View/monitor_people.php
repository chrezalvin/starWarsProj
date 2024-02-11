<?php include_once '../Controller/home.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include '../assets/jquery.php' ?>
    <?php include '../assets/bootstrap.php' ?>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>

    <title>View People</title>
</head>
<body>
    <!-- prompt for error -->
    <?php if($error != null): ?>
        <div class="d-flex justify-content-center">
            <div class="alert alert-danger alert-dismissible w-50 my-1">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Add Button -->
    <div class="position-absolute end-0 m-2">
        <button 
            class="btn btn-outline-success fw-bold text-warning"
            data-bs-toggle="modal"
            data-bs-target="#addPerson"
            >
            Add a Person
        </button>
    </div>

    <!-- modal for adding a person -->
    <div class="modal" id="addPerson" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add a Person</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="./add_people.php" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="" required />
                    </div>
                    <div class="form-group">
                        <label for="height">Height</label>
                        <input type="number" name="height" id="height" class="form-control" value="0" min="0" required/>
                    </div>
                    <div class="form-group">
                        <label for="mass">Mass</label>
                        <input type="number" name="mass" id="mass" class="form-control" value="0" min="0" required/>
                    </div>
                    <div class="form-group">
                        <label for="hair_color">Hair Color</label>
                        <input type="text" name="hair_color" id="hair_color" class="form-control" value="brown" />
                    </div>
                    <div class="form-group">
                        <label for="skin_color">Skin Color</label>
                        <input type="text" name="skin_color" id="skin_color" class="form-control" value="white" />
                    </div>
                    <div class="form-group">
                        <label for="eye_color">Eye Color</label>
                        <input type="text" name="eye_color" id="eye_color" class="form-control" value="dark" />
                    </div>
                    <div class="form-group">
                        <label for="birth_year">Birth Year</label>
                        <div class="input-group">
                            <input type="number" name="birth_year" id="birth_year" class="form-control" value="0" min="0" required/>
                            <div class="input-group-append">
                                <select name="birth_year_indicator" id="birthyear" class="form-select">
                                    <option value="BBY" selected>BBY</option>
                                    <option value="ABY">ABY</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <input type="text" name="gender" id="gender" class="form-control" value="male" />
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

    <h1 class="text-center">People</h1>
    <div class="d-flex justify-content-center">
        <form action="" class="w-50 d-flex justify-content-center gap-2">
            <div class="input-group">
                <input
                    type="text"
                    name="search"
                    class="form-control text-center"
                    placeholder="Search for name here"
                    value="<?= $search ?? "" ?>"
                />
                <button class="btn btn-outline-primary">Search</button>
            </div>
        </form>
    </div>
    <table class="table w-100 px-4">
        <tr class="text-center">
            <th>Name</th>
            <th>Height</th>
            <th>Mass</th>
            <th>Hair Color</th>
            <th>skin color</th>
            <th>eye color</th>
            <th>birth year</th>
            <th>gender</th>
            <th>Action</th>
        </tr>
        <?php foreach($people as $person): ?>
                <div class="modal" id="modal<?= $person->getId() ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirmation</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete <?= $person->getName() ?>?</p>
                                <p>This data cannot be recovered afterwards</p>
                            </div>
                            <div class="modal-footer">
                                <form method="post" action="./delete_people.php">
                                    <input type="hidden" name="deleteId" value="<?= $person->getId() ?>" />
                                    <button type="submit" class="btn btn-danger">Yes, Delete It</button>
                                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="modal" id="modalEdit<?= $person->getId() ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="./edit_people.php" method="post">
                                <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $person->getId() ?>" />
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" value="<?= $person->getName() ?>" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="height">Height</label>
                                        <input type="number" name="height" id="height" class="form-control" value="<?= $person->getHeight() ?>" min="0" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="mass">Mass</label>
                                        <input type="number" name="mass" id="mass" class="form-control" value="<?= $person->getMass() ?>" min="0" required/>
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
                                        <button class="btn btn-primary" type="submit">Update</button>
                                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <tr class="text-center align-middle">
                <td><?= $person->getName() ?></td>
                <td><?= $person->getHeight() ?></td>
                <td><?= $person->getMass() ?></td>
                <td><?= $person->getHairColor() ?></td>
                <td><?= $person->getSkinColor() ?></td>
                <td><?= $person->getEyeColor() ?></td>
                <td><?= $person->getBirthYear() ?></td>
                <td><?= $person->getGender() ?></td>
                <td class="d-flex justify-content-center gap-1">
                    <button
                        type="button"
                        data-bs-toggle="modal" 
                        data-bs-target="#modalEdit<?= $person->getId() ?>"
                        class="btn btn-warning"
                    >Edit</button>
                    <!-- <a href="../View/edit_people.php?id=<?= $person->getId() ?>" class="btn btn-warning">Edit</a> -->
                    <button
                        type="button"
                        data-bs-toggle="modal" 
                        data-bs-target="#modal<?= $person->getId() ?>"
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