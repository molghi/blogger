<form action="<?php echo $mode === 'add' ? '../public/index.php?action=addpost' : "../public/index.php?action=editpost&postid=" . $post_to_edit['id'] ;?>" class="mt-6 space-y-6 max-w-2xl mx-auto" method="POST" enctype="multipart/form-data">
  <!-- Title -->
  <div>
    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-blue-400">Title</label>
    <input name="title" type="text" id="title" autofocus="true" 
        class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500"
        value="<?php echo $mode === 'add' ? '' : $post_to_edit['title']; ?>"
    >
  </div>

  <!-- Body -->
  <div>
    <label for="body" class="block text-sm font-medium text-gray-700 dark:text-blue-400">Body <span class="text-red-500">*</span></label>
    <textarea name="body" id="body"  rows="6"
              class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-indigo-500 min-h-[100px] focus:ring focus:ring-indigo-500"><?php echo $mode === 'add' ? '' : $post_to_edit['body']; ?></textarea>
  </div>

  <!-- Categories -->
  <div>
    <label for="categories" class="block text-sm font-medium text-gray-700 dark:text-blue-400">Categories (optional)</label>
    <input name="categories" type="text" id="categories" 
        class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500"
        value="<?php echo $mode === 'add' ? '' : $post_to_edit['categories']; ?>"
    >
  </div>

  <!-- Cover Image & Visibility -->
  <div class="flex flex-col sm:flex-row sm:space-x-6 space-y-6 sm:space-y-0">
    <!-- Cover Image -->
    <div class="flex-1">
      <label for="cover_image" class="block text-sm font-medium text-gray-700 dark:text-blue-400">
        <?php 
        $to_echo = $mode === 'add' ? 'Cover Image (optional)' : 'Choose <span class="underline">New</span> Cover Image (optional)'; 
        echo $post_to_edit['image_path'] ? $to_echo : 'Choose Cover Image (optional)'; ?>
      </label>
      <input name="cover_image" type="file" id="cover_image" accept="image/png, image/jpeg"
            class="mt-1 block w-full text-gray-700 dark:text-gray-200"
            value="<?php echo $mode === 'add' ? '' : $post_to_edit['image_path']; ?>"
        >
        <?= $mode === 'edit' && $post_to_edit['image_path']  ? '<span class="block text-[12px] mt-1 text-[coral]">This will overwrite your existing cover image</span>' : '' ?>
        <?php echo $mode === 'edit' && $post_to_edit['image_path'] ? '<button type="button" class="text-white mt-4 font-medium py-2 px-4 rounded-md bg-gray-700 hover:bg-gray-600 delete-cover">Delete existing cover image</button>' : ''; ?>
    </div>

    <!-- Visibility -->
    <div class="flex-1">
      <span class="block text-sm font-medium text-gray-700 dark:text-blue-400">Visibility <span class="text-red-500">*</span></span>
      <div class="mt-2 flex space-x-4">
        <label class="inline-flex items-center">
          <input name="visibility" type="radio" value="0" class="text-indigo-600 border-gray-300 focus:ring-indigo-500"
            <?php echo $mode === 'edit' && $post_to_edit['visibility'] == 0 ? 'checked' : ''; ?>
          >
          <span class="ml-2">Draft</span>
        </label>
        <label class="inline-flex items-center">
          <input name="visibility" type="radio" value="1" class="text-indigo-600 border-gray-300 focus:ring-indigo-500"
            <?php echo $mode === 'edit' && $post_to_edit['visibility'] == 1 ? 'checked' : 'checked'; ?>
          >
          <span class="ml-2">Published</span>
        </label>
      </div>
    </div>
  </div>

  <!-- Submit Button -->
  <div>
    <button type="submit"
            class="w-full text-white font-medium py-2 px-4 rounded-md shadow <?php echo $mode === 'add' ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-green-600 hover:bg-green-700'; ?>">
        <?php echo $mode === 'add' ? 'Add' : 'Edit'; ?>
    </button>
  </div>

   <!-- OUTPUT ERRORS -->
    <?php if (isset($_SESSION['post_error'])): ?>
        <div class="bg-gray-900 border border-red-400 text-red-700 px-4 py-3 rounded-md mt-4" role="alert">
            <strong class="font-bold">Error: </strong>
            <span class="block sm:inline"><?php echo $_SESSION['post_error']; ?></span>
        </div>
    <?php unset($_SESSION['post_error']); ?>
    <?php endif; ?>
</form>