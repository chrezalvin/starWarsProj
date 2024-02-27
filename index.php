<?php require_once('./include/top.php') ?>

<?= top("My Star Wars Watchers") ?>
<body>
    <img 
        src="./assets/Star_wars2.svg" 
        class="img-fluid position-absolute top-50 start-50 translate-middle z-n1"
        style="opacity: 0.1;"
        alt=""
    >
    <div class="d-flex vh-100 justify-content-center">
        <div class="d-flex justify-content-center align-items-center flex-column">
            <h1>Welcome to Star Wars Watchers</h1>
            <!-- <h4 class="text-warning border">May The Force Be With You</h4> -->
            <a href="./View/login.php" class="d-block w-50 d-flex justify-content-center">
                <button
                    class="btn btn-primary flex-grow-0 w-50"
                    >
                    Login
                </button>
            </a>
        </div>
    </div>
</body>
</html>
