<?php

    session_start();

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;    // essentially check if logged in or not

    $is_index_page = str_contains($_SERVER['SCRIPT_FILENAME'], 'index.php');
    $is_home_page = str_contains($_SERVER['SCRIPT_FILENAME'], 'home.php');

    if (!$user_id && !$is_index_page) {
        header('Location: ../public/index.php');    // take to entry page (all who not logged in)
        exit();
    }
    
    $action_attr = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : null;
    $req_meth = $_SERVER['REQUEST_METHOD'];
    
    if ($user_id && $is_index_page && !$action_attr) { 
        header('Location: ../public/home.php');    // take home if logged in & accessing index/entry page without any attr
    }

    // if ($user_id && !$is_home_page) {
    //     header('Location: /php-crash/php-projs/06-blogger/public/home.php');    // take to home page (all who logged in)
    //     exit();
    // }