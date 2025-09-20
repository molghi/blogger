<div class="posts <?= $view === 'grid' ? 'container mx-auto grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-y-4 gap-x-8 auto-cols-fr' : '' ?>">
    <?php foreach ($user_posts as $post): ?>

        <div class="relative mx-auto bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-md space-y-4 mb-7 post <?= $view === 'grid' ? 'w-full' : 'max-w-3xl' ?>" data-post-id="<?= $post['id'] ?>">
    
            <!-- Cover Image -->
            <?php if ($post['image_path']): ?>
                <div class="hover:opacity-70 transition-all duration-300">
                    <a href="../public/post.php?postid=<?= $post['id'] ?>">
                        <img alt="Cover Image" src="<?= $post['image_path'] ?>" class="w-full max-h-[250px] rounded-md object-cover <?= $view === 'grid' ? 'h-[200px]' : 'h-auto' ?>">
                    </a>
                    <!-- src="<?= $post['image_path'] ?? 'placeholder.jpg' ?>" -->
                </div>
            <?php else: ?>
                <?= $view === 'grid' ? '<a href="../public/post.php?postid=' . $post['id'] . '" class="block h-[200px] bg-[#111] rounded text-white flex items-center justify-center italic hover:opacity-70 transition-all duration-300"><span>No Image</span></a>' : '' ?>
            <?php endif; ?>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 post-title hover:underline inline-block">
                <a href="../public/post.php?postid=<?= $post['id'] ?>"><?= htmlspecialchars(strip_tags($post['title'])) ?></a>
            </h2>

            <!-- Body -->
            <div class="text-gray-800 dark:text-gray-200 post-body">
                <?php
                    $ending = '';
                    if ($view === 'list' && strlen(htmlspecialchars(strip_tags($post['body']))) > 295) { $ending = '...'; }
                    if ($view === 'grid' && strlen(htmlspecialchars(strip_tags($post['body']))) > 180) { $ending = '...'; }
                ?>
                <?php echo $view === 'list' 
                    ? substr(htmlspecialchars(strip_tags($post['body'])), 0, 295) . $ending 
                    : substr(htmlspecialchars(strip_tags($post['body'])), 0, 180) . $ending ?>
            </div>

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