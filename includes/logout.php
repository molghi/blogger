<?php

    session_start();
    session_unset();
    session_destroy();
    
    header("Location: /php-crash/php-projs/06-blogger/public/index.php");
    exit();