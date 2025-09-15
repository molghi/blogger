<?php

    require_once('../includes/init.php');

    // passing things to header.php
    $doc_title = 'PHP Blogger: Auth';
    $logo_text = '<span class="text-blue-300">PHP Blogger</span>: Auth';

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;

    if ($action) {
        require_once('../includes/Validator.php');
        require_once('../includes/Database.php');
        require_once('../controllers/AuthController.php');
        $val = new Validator;
        $db = new Database;
        $auth = new AuthController($db, $val);

        switch ($action) {
            case 'signup':
                $auth->signup();
                break;
            case 'login':
                $auth->login();
                break;
            default: 
                break;
        }
    }
?>

<!-- ======================================================================================================================== -->

<!-- TOP PART -->
<?php require_once('../views/header.php'); ?>



<!-- AUTH BLOCK -->
<?php require_once('../views/auth_block.php'); ?>
    


<!-- BOTTOM PART -->
<?php require_once('../views/footer.php'); ?>

<!-- ======================================================================================================================== -->
