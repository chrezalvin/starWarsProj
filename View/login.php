<?php require_once '../Controller/login.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include '../assets/bootstrap.php' ?>
    <?php include '../assets/jquery.php' ?>

    <title>Login</title>
</head>
<body>
    <img 
        src="../assets/Star_wars2.svg" 
        class="img-fluid position-absolute top-50 start-50 translate-middle z-n1"
        style="opacity: 0.1;"
        alt=""
    >
        <?php if($error !== null): ?>
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>
    <div class="d-flex vh-100 justify-content-center">
        <div class="d-flex justify-content-center align-items-center flex-column">
            <h1>Welcome to Star Wars Watchers</h1>
            <div class="d-flex justify-content-center flex-column p-4 shadow">
                <h3>Please Login First</h3>
                <form action="./login.php" method="post" class="d-flex flex-column">
                    <input
                        type="text"
                        name="username"
                        class="form-control my-2"
                        placeholder="Username"
                        required
                    >
                    <input
                        type="password"
                        name="password"
                        class="form-control my-2"
                        placeholder="Password"
                        required
                    >
                    <div class="d-flex justify-content-center">
                        <button
                            type="submit"
                            class="btn btn-primary flex-grow-0 w-50"
                            >
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
