<!-- base app -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include './assets/bootstrap.php' ?>
    <?php include './assets/jquery.php' ?>

    <title>My Star Wars Watchers</title>
</head>
<body>
    <div class="d-flex vh-100 justify-content-center">
        <div class="d-flex justify-content-center align-items-center flex-column">
            <h1>Welcome to Star Wars Watchers</h1>
            <a href="./View/monitor_people.php" class="d-block w-50 d-flex justify-content-center">
                <button
                    class="btn btn-primary flex-grow-0 w-50"
                    >
                    Enter
                </button>
            </a>
        </div>
    </div>
</body>
</html>
