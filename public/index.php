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
        require_once('../controllers/PostController.php');
        $val = new Validator;
        $db = new Database;
        $auth = new AuthController($db, $val);
        $post = new PostController;

        switch ($action) {
            case 'signup':
                $auth->signup();
                break;
            case 'login':
                $auth->login();
                break;
            case 'addpost':
                $post->add();
                break;
            case 'editpost':
                $post_id = $_REQUEST['postid'];
                $post->edit($post_id);
                break;
            case 'deletepost':
                $post_id = $_REQUEST['post'];
                $post->delete($post_id);
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
