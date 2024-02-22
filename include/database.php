<?php
    include_once('../assets/secret.php');

    function database(){
        return new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
    }

    function pdo(){
        $host = DB_HOSTNAME;
        $db = DB_NAME;
        $charset = DB_CHARSET;
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    
        return new PDO($dsn, DB_USERNAME, DB_PASSWORD);
    }