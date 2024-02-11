<?php

    define("BASE_URL", getenv('API_BASE_URL') ?? "");
    if(BASE_URL == null)
        die("BASE_URL is not set");

    define("DB_HOSTNAME", getenv('DB_HOSTNAME') ?? "localhost");
    if(DB_HOSTNAME == null)
        die("DB_HOSTNAME is not set");

    define("DB_USERNAME", getenv('DB_USERNAME') ?? "root");
    if(DB_USERNAME == null)
        die("DB_USERNAME is not set");

    define("DB_PASSWORD", getenv('DB_PASSWORD') ?? "");
        if(DB_PASSWORD == null)
            die("DB_PASSWORD is not set");

    define("DB_NAME", getenv('DB_NAME') ?? "starwars");
        if(DB_NAME == null)
            die("DB_NAME is not set");