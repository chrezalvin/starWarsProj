<?php 
    require_once('../Controller/edit_people.php') 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include '../assets/bootstrap.php' ?>
    <?php include '../assets/jquery.php' ?>

    <script>
        $('document').ready(() => {
            $('#cancel').on('click', (e) => {
                e.preventDefault();
            })
        })
    </script>

    <title>Edit</title>
</head>
<body class="d-flex justify-content-center vw-100 min-vh-100">
    <div class="w-50 align-self-center shadow p-3 rounded-2 my-4">
        <?php if($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <div class="alert alert-<?= $update ? 'success' : 'danger' ?>">
                <?= $update ? 'Update Success' : 'Update Failed' ?>
                <?= json_encode($update) ?>
            </div>
        <?php endif; ?>
        <h2 class="text-center">Edit <?= $people->getName() ?></h2>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?= $people->getId() ?>" />
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?= $people->getName() ?>" />
            </div>
            <div class="form-group">
                <label for="height">Height</label>
                <input type="number" name="height" id="height" class="form-control" value="<?= $people->getHeight() ?>" />
            </div>
            <div class="form-group">
                <label for="mass">Mass</label>
                <input type="number" name="mass" id="mass" class="form-control" value="<?= $people->getMass() ?>" />
            </div>
            <div class="form-group">
                <label for="hair_color">Hair Color</label>
                <input type="text" name="hair_color" id="hair_color" class="form-control" value="<?= $people->getHairColor() ?>" />
            </div>
            <div class="form-group">
                <label for="skin_color">Skin Color</label>
                <input type="text" name="skin_color" id="skin_color" class="form-control" value="<?= $people->getSkinColor() ?>" />
            </div>
            <div class="form-group">
                <label for="eye_color">Eye Color</label>
                <input type="text" name="eye_color" id="eye_color" class="form-control" value="<?= $people->getEyeColor() ?>" />
            </div>
            <div class="form-group">
                <label for="birth_year">Birth Year</label>
                <input type="text" name="birth_year" id="birth_year" class="form-control" value="<?= $people->getBirthYear() ?>" />
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <input type="text" name="gender" id="gender" class="form-control" value="<?= $people->getGender() ?>" />
            </div>

            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-primary" type="submit">Update</button>
                <a href="./monitor_people.php" class="btn btn-warning">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>