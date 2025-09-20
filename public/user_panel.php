<?php

    require_once('../includes/init.php');

    // passing things to header.php
    $doc_title = 'PHP Blogger: User Panel';
    $logo_text = '<span class="text-blue-300">PHP Blogger</span>: User Panel';

    if (!$user_id) {
        header("Location: ./home.php?page=1");
        exit();
    }

    require_once('../includes/Database.php');
    $db = new Database;
    // fetch username
    $username = $db->get_username($user_id);

    // fetch all user posts
    $user_posts = $db->get_user_posts($user_id);

    // fetch comments count
    $user_comments_count = $db->get_user_posts_comments($user_id);

    function get_comments_num_to_post (array $arr, $post_id):int {
        // $arr == $user_comments_count
        $result = 0;
        foreach($arr as $item) {
            if ((int) $item['id'] === (int) $post_id) {
                $result = $item['count'];
                break;
            }
        }
        return $result;
    }
?>


<!-- ======================================================================================================================== -->


<!-- TOP PART -->
<?php require_once('../views/header.php'); ?>



<!-- MAIN PAGE CONTENT -->
<div class="container mx-auto flex items-center justify-between relative mb-8">
    <a class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 back-btn" href="./home.php?page=1">Back Home</a>
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 text-center mb-6 absolute left-1/2 transform -translate-x-1/2 top-[1px]">
        User Panel
    </h1>
</div>
<?php require_once('../views/panel_block.php'); ?>


<!-- BOTTOM PART -->
<?php require_once('../views/footer.php'); ?>
