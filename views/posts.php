<div class="posts">
    <?php foreach ($user_posts as $post): ?>

        <div class="relative max-w-3xl mx-auto bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-md space-y-4 mb-7 post" data-post-id="<?= $post['id'] ?>">

            <!-- Buttons: top-right -->
            <div class="absolute top-2 right-2 flex space-x-2">
                <a href="<?= $post['id'] ?>" class="px-3 py-1 bg-purple-700 hover:opacity-100 opacity-40 text-white rounded-md text-sm comment-post">Comment</a>
                <a href="../public/post-form.php?action=edit&postid=<?= $post['id'] ?>" class="px-3 py-1 bg-yellow-700 hover:opacity-100 opacity-40 text-white rounded-md text-sm edit-post">Edit</a>
                <button class="px-3 py-1 bg-red-700 hover:opacity-100 opacity-40 text-white rounded-md text-sm delete-post">Delete</button>
            </div>
    
            <!-- Cover Image -->
            <?php if ($post['image_path']): ?>
                <div>
                    <img alt="Cover Image" src="<?= $post['image_path'] ?>" class="w-full h-auto max-h-[250px] rounded-md object-cover">
                    <!-- src="<?= $post['image_path'] ?? 'placeholder.jpg' ?>" -->
                </div>
            <?php endif; ?>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 post-title"><?= htmlspecialchars(strip_tags($post['title'])) ?></h2>

            <!-- Body -->
            <p class="text-gray-800 dark:text-gray-200 whitespace-pre-line post-body"><?= htmlspecialchars(strip_tags($post['body'])) ?></p>

            <!-- Categories -->
            <?php if (!empty($post['categories'])): ?>
                <p class="text-sm text-gray-600 dark:text-gray-400"><span class="font-bold">Categories:</span> <?= htmlspecialchars(strip_tags($post['categories'])) ?></p>
            <?php endif; ?>

            <!-- Visibility & Created At -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center text-sm text-gray-600 dark:text-gray-400">
                <span><span class="font-bold">Visibility:</span> <?= $post['visibility'] ? 'Published' : 'Draft' ?></span>
                <span><span class="font-bold">Created:</span> <span class="post-created"><?= date('Y-m-d H:i', strtotime($post['created_at'])) ?></span></span>
            </div>

        </div>


    <?php endforeach; ?>
</div>