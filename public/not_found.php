<?php

    require_once('../includes/init.php');

    // passing things to header.php
    $doc_title = 'PHP Blogger: Not Found';
    $logo_text = '<span class="text-blue-300">PHP Blogger</span>: Not Found';

    if (!isset($_SESSION['not-found'])) {
        header("Location: ./home.php?page=1");
        exit();
    } else {
        unset($_SESSION['not-found']);
    }
?>

<!-- ======================================================================================================================== -->

<!-- TOP PART -->
<?php require_once('../views/header.php'); ?>



<!-- MAIN PAGE CONTENT -->
<?php require_once('../views/404_not_found.php'); ?>



<!-- BOTTOM PART -->
<?php require_once('../views/footer.php'); ?>