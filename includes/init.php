<?php

    session_start();

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;    // essentially check if logged in or not

    $is_index_page = str_contains($_SERVER['SCRIPT_FILENAME'], 'index.php');
    $is_home_page = str_contains($_SERVER['SCRIPT_FILENAME'], 'home.php');

    if (!$user_id && !$is_index_page) {
        header('Location: /php-crash/php-projs/06-blogger/public/index.php');    // take to entry page (all who not logged in)
        exit();
    }

    // if ($user_id && !$is_home_page) {
    //     header('Location: /php-crash/php-projs/06-blogger/public/home.php');    // take to home page (all who logged in)
    //     exit();
    // }