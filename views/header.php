<?php

    require_once('../includes/init.php');

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
    <style>
        /* shut up red non-https warning */
        body > div:last-child {  
            display: none;
        }
    </style>
</head>
<body class="bg-gray-900 text-white min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-black text-white p-4 shadow-md">
    <div class="container mx-auto flex items-center justify-between">
        
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
                <button class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-md active:opacity-70 logout-btn">Log Out</button>
            <?php else: ?>
                <span class="italic">Post your thoughts, share ideas, and connect with people!</span>
            <?php endif; ?>
        </div>
        
    </div>
    </header>


    <!-- MAIN PAGE CONTENT -->
    <main class="flex-1 bg-gray-900 text-white p-6">

