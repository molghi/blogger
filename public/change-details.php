<?php

    require_once('../includes/init.php');

    // passing things to header.php
    $doc_title = 'PHP Blogger: Update Info';
    $logo_text = '<span class="text-blue-300">PHP Blogger</span>: Update Info';

    $action_path = trim(htmlspecialchars($_REQUEST['action']));

    if ($action_path === 'username') {
        // fetch username
        require_once('../includes/Database.php');
        $db = new Database;
        $username = $db->get_username($user_id);
    }
?>

<!-- ======================================================================================================================== -->

<!-- TOP PART -->
<?php require_once('../views/header.php'); ?>



<!-- MAIN PAGE CONTENT -->
<div class="container mx-auto flex items-center justify-between relative mb-8">
    <a class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 back-btn" href="./home.php?page=1">Back Home</a>
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 text-center mb-6 absolute left-1/2 transform -translate-x-1/2 top-[1px]">
        Update Your <?= ucfirst($action_path); ?>
    </h1>
</div>
<?php require_once('../views/update-form.php'); ?>



<!-- BOTTOM PART -->
<?php require_once('../views/footer.php'); ?>
