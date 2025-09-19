<!-- POST BLOCK -->

<article class="bg-white dark:bg-gray-900 rounded-xl shadow post-block" data-post-id="<?= $fetched_post['id'] ?>">
  
    <!-- Title -->
    <div class="flex items-center justify-between relative mt-4">
        <a class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 back-btn" href="./home.php">Back</a>
        
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 text-center mb-6 absolute left-1/2 transform -translate-x-1/2 top-[1px] post-title">
            <?= htmlspecialchars($fetched_post['title']) ?>
        </h1>
    </div>

    <div class="max-w-3xl mx-auto p-6">

  <!-- <h1 class="text-3xl font-bold mb-4 text-gray-900 dark:text-gray-100 text-center post-title"><?= htmlspecialchars($fetched_post['title']) ?></h1> -->

  <!-- Buttons --> 
   <!-- CAN EDIT/DELETE POST ONLY IF ITS YOUR POST -->
    <?php if ($user_id && $fetched_post['user_id'] === $user_id): ?>
        <div class="flex space-x-2 justify-end mb-4">
            <!-- <a href="<?= $post['id'] ?>" class="px-3 py-1 bg-purple-700 hover:opacity-100 opacity-40 text-white rounded-md text-sm comment-post">Comment</a> -->
            <a href="../public/post-form.php?action=edit&postid=<?= $fetched_post['id'] ?>" class="px-3 py-1 bg-yellow-700 hover:opacity-100 opacity-30 text-white rounded-md text-sm active:opacity-70 edit-post" title="Edit post">Edit</a>
            <button class="px-3 py-1 bg-red-700 hover:opacity-100 opacity-30 text-white rounded-md text-sm active:opacity-70 delete-post" title="Delete post">Delete</button>
        </div>
    <?php endif; ?>

  <!-- Image -->
  <?php if ($fetched_post['image_path']): ?>
    <div class="mb-6 overflow-hidden rounded-lg">
        <img src="<?= htmlspecialchars($fetched_post['image_path']) ?>" alt="Post cover" class="w-full h-full object-cover max-h-[450px] transition-transform duration-1000 ease-in-out hover:scale-105 shadow-md">
    </div>
  <?php endif; ?>

  <!-- Body -->
  <div class="text-gray-700 dark:text-gray-300 mb-10 post-body whitespace-pre-line">
    <?= htmlspecialchars($fetched_post['body']) ?>
    <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque habitant morbi tristique senectus.</p> -->
  </div>

  <!-- Categories -->
   <?php if ($fetched_post['categories']): ?>
   <div class="text-sm text-gray-500 dark:text-gray-400 mb-6">
    <span class="font-bold">Categories: </span>
     <span class="font-medium"><?= htmlspecialchars($fetched_post['categories']) ?></span>
   </div>
  <?php endif; ?>

  <!-- Visibility & Created -->
   <!-- <?php print_r($fetched_post); ?> -->
   
  <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
    <div>
        <div class="mb-2">
            <span class="font-bold">Author: </span><?= $fetched_post['username'] ?>
        </div>
        <div>
            <span class="font-bold">Visibility: </span><?= $fetched_post['visibility'] == '1' ? 'Published' : 'Draft' ?>
        </div>
    </div>
    <div>
        <div class="mb-2 flex gap-2">
            <span class="font-bold min-w-[70px]">Created: </span>
            <span class="post-created inline-block text-right min-w-[121px]"><?= substr(htmlspecialchars($fetched_post['created_at']), 0, -3) ?></span>
        </div>
        <div class="flex gap-2">
            <span class="font-bold min-w-[70px]">Modified: </span>
            <span class="post-created inline-block text-right min-w-[121px]"><?= substr(htmlspecialchars($fetched_post['modified_at']), 0, -3) ?></span>
        </div>
    </div>
</div>

  <!-- Divider -->
  <hr class="border-gray-300 dark:border-gray-700 my-10">

  </div>

</article>


<!-- ======================================================================================================================== -->
<!-- ======================================================================================================================== -->


<!-- COMMENTS SECTION -->

<section class="max-w-2xl mx-auto p-4 pt-0 pb-10 bg-white dark:bg-gray-900 rounded-xl shadow">
  <!-- Heading -->
  <h2 class="text-2xl text-center font-semibold mb-8 text-gray-900 dark:text-gray-100">
    Comments
    <?= count($fetched_comments) > 0 ? ' (' . count($fetched_comments) . ')' : '' ?>
  </h2>

  <?php if (count($fetched_comments) > 0): ?>
    <div class="comments">
        <?php foreach($fetched_comments as $comment) :?>
            <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4 comment" data-comment-id="<?= htmlspecialchars($comment['id']) ?>">
                <!-- Username -->
                <p class="font-medium text-gray-800 dark:text-gray-200 mb-1" data-user-id="<?= htmlspecialchars($comment['user_id']) ?>">
                    <span class="font-bold"><?= htmlspecialchars($comment['username']) ?></span> said:
                </p>

                <!-- Body -->
                <p class="text-gray-700 dark:text-gray-300 mb-2 italic comment-text">
                    <span><?= htmlspecialchars($comment['body']) ?></span>
                </p>

                <!-- Footer -->
                <div class="flex justify-between items-center text-[14px] text-gray-500 dark:text-gray-400">
                    <span>
                        <span class="font-bold">Date: </span>
                        <?= substr(htmlspecialchars($comment['created_at']), 0, -3) ?>
                    </span>
                    <!-- CAN DELETE COMMENT ONLY IF ITS YOUR POST -->
                    <?php if ($user_id && $fetched_post['user_id'] === $user_id): ?>
                        <button class="text-red-600 hover:underline opacity-50 hover:opacity-100 delete-comment">Delete comment</button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="italic">Comments will be here...</div>
  <?php endif; ?>

</section>


<!-- ======================================================================================================================== -->
<!-- ======================================================================================================================== -->


<!-- ADD COMMENT FORM (only if there is a user_id aka if logged in) -->
<?php if ($user_id): ?>
    <form action="../public/index.php?action=addcomment&postid=<?= $fetched_post['id'] ?>" method="POST" class="max-w-2xl mx-auto p-4 bg-white dark:bg-gray-900 rounded-xl shadow">
    <!-- Comment Body -->
    <label for="comment-body" class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-1">
        Add a Comment
    </label>
    <textarea id="comment-body" name="body" rows="3" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-100 min-h-[50px] max-h-[500px]"></textarea>

    <!-- Submit -->
    <button type="submit" 
        class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-300">
        Post Comment
    </button>

    <!-- OUTPUT ERRORS -->
        <?php if (isset($_SESSION['error_comment'])): ?>
            <div class="bg-gray-900 border border-red-400 text-red-700 px-4 py-3 rounded-md mt-4" role="alert">
                <strong class="font-bold">Error: </strong>
                <span class="block sm:inline"><?php echo $_SESSION['error_comment']; ?></span>
            </div>
        <?php unset($_SESSION['error_comment']); ?>
        <?php endif; ?>
        <!--  -->
    </form>
<?php else: ?>
    <div class="max-w-2xl mx-auto text-center mb-8">Log in or sign up to leave a comment</div>
<?php endif; ?>