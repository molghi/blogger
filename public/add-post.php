<?php

    require_once('../includes/init.php');

    // passing things to header.php
    $doc_title = 'PHP Blogger: Add Post';
    $logo_text = '<span class="text-blue-300">PHP Blogger</span>: Add Post';
?>

<!-- ======================================================================================================================== -->

<!-- TOP PART -->
<?php require_once('../views/header.php'); ?>



<!-- MAIN PAGE CONTENT -->
<h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 text-center mb-6">Add Post</h1>
<?php require_once('../views/add-form.php'); ?>




<!-- BOTTOM PART -->
<?php require_once('../views/footer.php'); ?>
