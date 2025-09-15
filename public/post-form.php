<?php

    require_once('../includes/init.php');

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;

    $mode = 'add';
    
    if ($action === 'add') {
        // passing things to header.php
        $doc_title = 'PHP Blogger: Add Post';
        $logo_text = '<span class="text-blue-300">PHP Blogger</span>: Add Post';
    }
    elseif ($action === 'edit') {
        // passing things to header.php
        $doc_title = 'PHP Blogger: Edit Post';
        $logo_text = '<span class="text-blue-300">PHP Blogger</span>: Edit Post';
        $mode = 'edit';
        // fetch post to edit
        $post_id = $_REQUEST['postid'];
        require_once('../includes/Database.php');
        $db = new Database;
        $post_to_edit = $db->get_post($user_id, $post_id);
        // print_r($post_to_edit);
    }
?>

<!-- ======================================================================================================================== -->

<!-- TOP PART -->
<?php require_once('../views/header.php'); ?>



<!-- MAIN PAGE CONTENT -->
    <!-- TITLE -->
    <div class="flex items-center justify-between relative">
        <a class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 back-btn" href="./home.php">Back</a>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 text-center mb-6 absolute left-1/2 transform -translate-x-1/2 top-[1px]">
            <?php echo $action === 'add' ? 'Add Post' : 'Edit Post'; ?>
        </h1>
    </div>
    <!-- ADD/EDIT FORM -->
    <?php require_once('../views/add-edit-form.php'); ?>



<!-- BOTTOM PART -->
<?php require_once('../views/footer.php'); ?>
