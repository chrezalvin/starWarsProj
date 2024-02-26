<?php
    session_start();
    require_once '../service/User.php';

    if(isset($_SESSION['userId']) && isset($_SESSION['timestamp'])){
        header('Location: ./monitor.php');
        exit();
    }

    // check if it's post
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        $user = null;
        if($username && $password)
            $user = UserDatabase::login($username, $password);

        if($user){
            // store this session and timestamp
            $_SESSION['userId'] = $user->getId();
            $_SESSION['timestamp'] = time();

            header('Location: ./monitor.php');
        }
        else
            header('Location: ./login.php?error=Invalid username or password');
    }

    $error = $_GET['error'] ?? null;