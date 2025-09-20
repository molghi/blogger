<?php

    require_once('../includes/init.php');

    $is_user_panel_page = str_contains($_SERVER['PHP_SELF'], 'user_panel.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo isset($doc_title) ? $doc_title : 'PHP Blogger'; ?>
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/@preline/preline/dist/preline.css" rel="stylesheet">
    <script src="https://unpkg.com/@preline/preline/dist/preline.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* shut up red local non-https warning */
        div[style="background: red; color: white; padding: 10px; position: fixed; bottom: 0px; width: 100%; text-align: center; z-index: 1000;"] {
            display: none !important;
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-black text-white p-4 shadow-md">
    <div class="container mx-auto flex items-center justify-between flex-wrap sm:flex-nowrap gap-3 sm:gap-0">
        
        <!-- Logo -->
        <div class="text-2xl font-bold">
            <a class="hover:opacity-90" href="./index.php">
                <?php echo isset($logo_text) ? $logo_text : 'PHP Blogger'; ?>
            </a>
        </div>
        
        <!-- Buttons or stuff -->
        <div class="flex space-x-4">
            <?php if ($user_id): ?>
                <a href="../public/post-form.php?action=add" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-md active:opacity-70 add-post-btn">Add Post</a>
                <?php if (!$is_user_panel_page): ?>
                    <a href="../public/user_panel.php" class="px-4 py-2 bg-green-600 hover:bg-green-700 rounded-md active:opacity-70 add-post-btn">User Panel</a>
                <?php endif; ?>
                <button class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-md active:opacity-70 logout-btn">Log Out</button>
            <?php else: ?>
                <div class="flex items-center gap-5">
                    <span class="italic mr-[25px] xl:mr-[50px] hidden lg:inline">Post your thoughts, share ideas, and connect with people!</span>
                    <a href="../public/home.php" class="px-4 py-2 bg-blue-400 hover:bg-blue-500 rounded-md active:opacity-70 add-post-btn">View Posts</a>
                    <a href="../public/index.php" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-md active:opacity-70 add-post-btn">Log In | Sign Up</a>
                </div>
            <?php endif; ?>
        </div>
        
    </div>
    </header>


    <!-- MAIN PAGE CONTENT -->
    <main class="flex-1 bg-gray-900 text-white p-6">

