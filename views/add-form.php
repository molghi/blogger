<form action="#" class="space-y-6 max-w-2xl mx-auto" method="POST" enctype="multipart/form-data">
  <!-- Title -->
  <div>
    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-blue-400">Title</label>
    <input name="title" type="text" id="title" autofocus="true" 
           class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500">
  </div>

  <!-- Body -->
  <div>
    <label for="body" class="block text-sm font-medium text-gray-700 dark:text-blue-400">Body <span class="text-red-500">*</span></label>
    <textarea name="body" id="body" required rows="6"
              class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-indigo-500 min-h-[100px] focus:ring focus:ring-indigo-500"></textarea>
  </div>

  <!-- Categories -->
  <div>
    <label for="categories" class="block text-sm font-medium text-gray-700 dark:text-blue-400">Categories (optional)</label>
    <input name="categories" type="text" id="categories" 
           class="mt-1 px-4 py-2 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500">
  </div>

  <!-- Cover Image & Visibility -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-6 space-y-6 sm:space-y-0">
    <!-- Cover Image -->
    <div class="flex-1">
      <label for="cover_image" class="block text-sm font-medium text-gray-700 dark:text-blue-400">Cover Image (optional)</label>
      <input name="cover_image" type="file" id="cover_image" accept="image/png, image/jpeg"
             class="mt-1 block w-full text-gray-700 dark:text-gray-200">
    </div>

    <!-- Visibility -->
    <div class="flex-1">
      <span class="block text-sm font-medium text-gray-700 dark:text-blue-400">Visibility</span>
      <div class="mt-2 flex space-x-4">
        <label class="inline-flex items-center">
          <input name="visibility" type="radio" value="0" class="text-indigo-600 border-gray-300 focus:ring-indigo-500">
          <span class="ml-2">Draft</span>
        </label>
        <label class="inline-flex items-center">
          <input name="visibility" type="radio" value="1" checked class="text-indigo-600 border-gray-300 focus:ring-indigo-500">
          <span class="ml-2">Published</span>
        </label>
      </div>
    </div>
  </div>

  <!-- Submit Button -->
  <div>
    <button type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md shadow">
      Add
    </button>
  </div>
</form>