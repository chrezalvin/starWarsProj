<?php
    function top(string $title = ""){
        ob_start(); ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">

                <?php include '../assets/bootstrap.php' ?>
                <?php include '../assets/jquery.php' ?>

                <title><?= $title ?></title>
            </head>
        <?php 
        return ob_get_clean();
    }