<?php require_once('../include/top.php') ?>

<?= top("Not Found") ?>
<body>
    <img 
        src="../assets/Star_wars2.svg" 
        class="img-fluid position-absolute top-50 start-50 translate-middle z-n1"
        style="opacity: 0.1;"
        alt=""
    >
    <div class="vh-100 vw-100 d-flex justify-content-center align-items-center flex-column gap-2">
        <h3>You're Accessing an Unauthorized Page</h3>
        <a href="./" class="btn btn-primary">Back to Home</a>
    </div>
</body>
</html>