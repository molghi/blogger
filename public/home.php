<?php

    require_once('../includes/init.php');

    // passing things to header.php
    $doc_title = 'PHP Blogger: Home';
    $logo_text = '<span class="text-blue-300">PHP Blogger</span>: Home';

    require_once('../includes/Database.php');
    $db = new Database;

    // fetch user posts
    $user_posts = $db->get_user_posts($user_id);

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
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-500 text-center mb-2">User posts count: <?php echo count($user_posts); ?></h2>
    <!-- Btns toggling view -->
     <div class="flex items-center space-x-2 max-w-[768px] mx-auto justify-end mt-[-0px] mb-5 opacity-30 hover:opacity-100">
        <span>View: </span>
        <!-- List view button -->
        <a <?= $view === 'grid' ? 'href="home.php?view=list"' : '' ?> class="inline-flex items-center gap-x-2 py-2 px-4 text-sm font-medium rounded-lg border border-gray-600 text-gray-200 outline-none <?= $view === 'list' ? 'bg-blue-700' : 'hover:bg-gray-700 active:opacity-70 bg-gray-800' ?>" <?= $view === 'list' ? 'disabled' : '' ?>>
            <i class="fa-solid fa-list"></i>
            List
        </a>

        <!-- Grid view button -->
        <a <?= $view === 'list' ? 'href="home.php?view=grid"' : '' ?> class="inline-flex items-center gap-x-2 py-2 px-4 text-sm font-medium rounded-lg border border-gray-600 text-gray-200 outline-none <?= $view === 'grid' ? 'bg-blue-700' : 'hover:bg-gray-700 active:opacity-70 bg-gray-800' ?>" <?= $view === 'grid' ? 'disabled' : '' ?>>
            <i class="fa-solid fa-th"></i>
            Grid
        </a>
    </div>
    <!-- RENDER POSTS -->
    <?php require_once('../views/posts.php'); ?>
<?php else: ?>
    <h2 class="text-xl font-semibold italic text-gray-800 dark:text-gray-500 text-center">No posts to show...</h2>
<?php endif; ?>




<!-- BOTTOM PART -->
<?php require_once('../views/footer.php'); ?>
