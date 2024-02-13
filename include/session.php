<?php
    session_start();

    if(isset($_SESSION['userId']) && isset($_SESSION['timestamp'])){
        $session_time_limit = 30 * 60;
        // check if the time is expired (30 minutes)
        if(time() - $_SESSION['timestamp'] > $session_time_limit){
            session_unset();
            session_destroy();
            header('Location: ./login.php');
            exit();
        }
    }
    else
        header('Location: ./login.php');