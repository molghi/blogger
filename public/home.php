<?php

    require_once('../includes/init.php');

    // passing things to header.php
    $doc_title = 'PHP Blogger: Home';
    $logo_text = '<span class="text-blue-300">PHP Blogger</span>: Home';

    require_once('../includes/Database.php');
    $db = new Database;

    // fetch user posts
    $user_posts = $db->get_user_posts($user_id);
?>

<!-- ======================================================================================================================== -->

<!-- TOP PART -->
<?php require_once('../views/header.php'); ?>



<!-- MAIN PAGE CONTENT -->
<h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 text-center mb-6">Recent Posts</h1>

<?php if (count($user_posts) > 0): ?>
    <h2 class="text-xl font-semibold italic text-gray-800 dark:text-gray-500 text-center">There are some posts</h2>
<?php else: ?>
    <h2 class="text-xl font-semibold italic text-gray-800 dark:text-gray-500 text-center">No posts to show...</h2>
<?php endif; ?>




<!-- BOTTOM PART -->
<?php require_once('../views/footer.php'); ?>
