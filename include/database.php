<?php
    include_once('../assets/configs.php');

    function database(){
        return new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
    }