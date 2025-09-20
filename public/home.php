<?php

    require_once('../includes/init.php');

    // passing things to header.php
    $doc_title = 'PHP Blogger: Home';
    $logo_text = '<span class="text-blue-300">PHP Blogger</span>: Home';

    require_once('../includes/Database.php');
    $db = new Database;

    // define posts per page
    // $posts_per_page = 9;
    $posts_per_page = 3;

    // fetch total num of posts in db
    if (!$user_id) $all_posts_count = $db->get_num_of_posts()['count'];
    else $all_posts_count = $db->get_num_of_posts_loggedin($user_id)['count'];

    // get how many pages there'll be
    $pages = ceil($all_posts_count / $posts_per_page);
    if ($all_posts_count === 0) $pages = 1; // Edge case: when $all_posts_count = 0, $pages will be 0, which might break "if ($current_page > $pages)" logic.

    // define current page
    $current_page = isset($_SESSION['current_page']) ? $_SESSION['current_page'] : 1;
    if (isset($_REQUEST['page'])) { $current_page = $_REQUEST['page']; }
    // if (!isset($_REQUEST['page'])) { $current_page = 1; }
    // handle out of bounds
    if ($current_page < 1) {
        $current_page = 1;   
        header("Location: {$_SERVER['PHP_SELF']}?page=$current_page");
    }
    if ($current_page > $pages) {
        $current_page = $pages;
        header("Location: {$_SERVER['PHP_SELF']}?page=$current_page");
    }
    $_SESSION['current_page'] = $current_page;

    // fetch user posts
    // $user_posts = $db->get_user_posts($user_id);
    // $user_posts = $db->get_all_posts();
    $user_posts = $db->get_posts_for_page($current_page, $posts_per_page, $user_id);

    // configure posts view
    $view = isset($_SESSION['view']) ? $_SESSION['view'] : 'list';
    if (isset($_REQUEST['view'])) { $view = $_REQUEST['view']; }
    $_SESSION['view'] = $view;
?>

<!-- ======================================================================================================================== -->

<!-- TOP PART -->
<?php require_once('../views/header.php'); ?>



<!-- MAIN PAGE CONTENT -->
<h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 text-center mb-6">Recent Posts</h1>

<?php if (count($user_posts) > 0): ?>
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-500 text-center mb-2">Total posts count: <?php echo $all_posts_count; ?></h2>
    <!-- Btns toggling view -->
    <?php require_once('../views/view-btns.php'); ?>
    <!-- RENDER POSTS -->
    <?php require_once('../views/posts.php'); ?>
    <!-- Pagination -->
    <?php require_once('../views/pagination.php'); ?>
<?php else: ?>
    <h2 class="text-xl font-semibold italic text-gray-800 dark:text-gray-500 text-center">No posts to show...</h2>
<?php endif; ?>




<!-- BOTTOM PART -->
<?php require_once('../views/footer.php'); ?>
