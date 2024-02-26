<?php
    function top(string $title = ""){
        ob_start(); ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">

                <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>

                <meta name="keywords" content="star wars, kenobi, darth vader, swapi">
                <meta
                    name="description"
                    content="Star Wars Watchers is a website that allows you to monitor characters, planets, and many more."
                />
                <meta name="theme-color" content="#3B71CA" />

                <meta og:title="Star Wars Watchers">
                <meta og:description="Star Wars Watchers is a website that allows you to monitor characters, planets, and many more.">
                <meta og:image="https://i.ibb.co/Nszq1YG/image-2024-02-26-135118915.png">
                <meta og:url="https://starwarsproj.000webhostapp.com">
                <meta property="og:image:width" content="217" />
                <meta property="og:image:height" content="232" />

                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

                <title><?= $title ?></title>
            </head>
        <?php 
        return ob_get_clean();
    }