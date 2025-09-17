<div class="posts">
    <?php foreach ($user_posts as $post): ?>

        <div class="relative max-w-3xl mx-auto bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-md space-y-4 mb-7 post" data-post-id="<?= $post['id'] ?>">
    
            <!-- Cover Image -->
            <?php if ($post['image_path']): ?>
                <div class="hover:opacity-70 transition-all duration-300">
                    <a href="../public/post.php?postid=<?= $post['id'] ?>">
                        <img alt="Cover Image" src="<?= $post['image_path'] ?>" class="w-full h-auto max-h-[250px] rounded-md object-cover">
                    </a>
                    <!-- src="<?= $post['image_path'] ?? 'placeholder.jpg' ?>" -->
                </div>
            <?php endif; ?>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 post-title hover:underline inline-block">
                <a href="../public/post.php?postid=<?= $post['id'] ?>"><?= htmlspecialchars(strip_tags($post['title'])) ?></a>
            </h2>

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