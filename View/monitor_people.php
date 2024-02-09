<?php include_once '../Controller/home.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include '../assets/bootstrap.php' ?>
    <?php include '../assets/jquery.php' ?>

    <title>View People</title>
</head>
<body>
    <h1 class="text-center">People</h1>
    <div class="d-flex justify-content-center">
        <form action="" class="w-50 d-flex justify-content-center gap-2">
            <input type="text" name="search" class="form-control text-center" placeholder="Search for name here" />
            <button class="btn btn-primary">Search</button>
        </form>
    </div>
    <table class="table w-100 px-4">
        <tr class="text-center">
            <th>Id</th>
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
            <tr>
                <td><?= $person->getId() ?></td>
                <td><?= $person->getName() ?></td>
                <td><?= $person->getHeight() ?></td>
                <td><?= $person->getMass() ?></td>
                <td><?= $person->getHairColor() ?></td>
                <td><?= $person->getSkinColor() ?></td>
                <td><?= $person->getEyeColor() ?></td>
                <td><?= $person->getBirthYear() ?></td>
                <td><?= $person->getGender() ?></td>
                <td class="d-flex justify-content-center gap-1">
                    <a href="../View/edit_people.php?id=<?= $person->getId() ?>" class="btn btn-warning">Edit</a>
                    <a href="../Controller/delete_people.php?id=<?= $person->getId() ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>