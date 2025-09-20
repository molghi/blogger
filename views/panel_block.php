<!-- TOP -->
 <div class="container mx-auto flex items-center justify-between bg-gray-900 py-4 rounded-lg mb-10">
  
 <span class="text-white text-3xl font-bold">
    <span class="text-purple-600"><?= $username ?></span>'s dashboard
</span>

  <div class="flex gap-3">
    <a href="../public/change-details.php?action=username" class="px-4 py-2 bg-blue-600 text-white rounded-lg transition opacity-60 hover:opacity-100 active:opacity-70">
      Change username
    </a>
    <a href="../public/change-details.php?action=password" class="px-4 py-2 bg-green-600 text-white rounded-lg transition opacity-60 hover:opacity-100 active:opacity-70">
      Change password
    </a>
  </div>
</div>

<!-- output that pw updated successfully -->
<?php if (isset($_SESSION['pw_upd_msg'])): ?>
    <div class="container mx-auto bg-gray-900 border border-green-400 text-green-700 px-4 py-3 rounded-md mt-[-10px] mb-8" role="alert">
        <strong class="font-bold">Message: </strong>
        <span class="block sm:inline"><?php echo $_SESSION['pw_upd_msg']; ?></span>
    </div>
    <?php unset($_SESSION['pw_upd_msg']); ?>
<?php endif; ?>


<!-- BOTTOM -->
 <div class="container mx-auto pb-[100px]">
    <div class="text-2xl font-bold mb-4">Posts: <?= count($user_posts); ?></div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-300 bg-gray-900 text-white post-entries">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Post Title <span class="text-[10px] italic font-normal align-top text-[#999]">(Hover to see body snippet)</span></th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Visibility</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Published At <i class="fas fa-caret-down" style="transform: scale(1.2); margin-left: 3px;"></i></th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Comments</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold">View</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold">Edit</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold">Delete</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                <?php if (count($user_posts) > 0): ?>
                    <?php foreach($user_posts as $post): ?>
                    <tr class="hover:bg-[#222] post-entry" data-post-id="<?= $post['id'] ?>">
                        <td class="px-4 py-2" title="<?php echo substr($post['body'], 0, 50) . '...' ?>"><?= $post['title'] ?></td>
                        <td class="px-4 py-2 <?= $post['visibility'] == 1 ? 'text-green-500' : 'text-gray-500'; ?>"><?= $post['visibility'] == 1 ? 'Published' : 'Draft'; ?></td>
                        <td class="px-4 py-2"><?= $post['created_at'] ?></td>
                        <?php $comments_num = get_comments_num_to_post($user_comments_count, $post['id']); ?>
                        <td class="px-4 py-2 <?= $comments_num===0 ? 'text-[coral]' : ''; ?>"><?= $comments_num ?></td>
                        <td class="px-4 py-2 text-center">
                            <a href="../public/post.php?postid=<?= $post['id'] ?>"
                                class="px-3 py-1 bg-blue-600 rounded hover:bg-blue-700 transition active:opacity-70">View</a>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <a href="../public/post-form.php?action=edit&postid=<?= $post['id'] ?>" 
                                class="px-3 py-1 bg-green-600 rounded hover:bg-green-700 transition active:opacity-70">Edit</a>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button class="px-3 py-0.5 bg-red-600 rounded hover:bg-red-700 transition active:opacity-70 delete-post">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td class="italic px-4 py-2 bg-[#222] text-center" colspan="7">Nothing here yet...</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

 </div>