<?php

    require_once('../includes/init.php');

    // passing things to header.php
    $doc_title = 'PHP Blogger: Post Page';
    $logo_text = '<span class="text-blue-300">PHP Blogger</span>: Post Page';

    require_once('../includes/Database.php');
    $db = new Database;

    $post_id = htmlspecialchars($_GET['postid']);
    if(!$post_id) {
        header('Location: /php-crash/php-projs/06-blogger/public/home.php');
        exit();
    }
    
    // $fetched_post = $db->get_user_post($user_id, $post_id);
    $fetched_post = $db->get_post($post_id);

    $fetched_comments = $db->fetch_comments($post_id);
?>

<!-- ======================================================================================================================== -->

<!-- TOP PART -->
<?php require_once('../views/header.php'); ?>



<!-- MAIN PAGE CONTENT -->
 <!-- POST & COMMENTS TO IT -->
<?php require_once('../views/post_block.php'); ?>



<!-- BOTTOM PART -->
<?php require_once('../views/footer.php'); ?>