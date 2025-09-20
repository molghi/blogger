<div class="max-w-3xl mx-auto p-6 space-y-4">
  <!-- Full-width text -->
  <p class="text-lg text-gray-900 dark:text-gray-100 mb-8">
    <?php echo $action_path === 'username' ? "Current username: <span class='font-bold text-blue-300'>$username</span>" : 'Set your new password'?>
  </p>

  <!-- Form with one input and button -->
  <form action="../public/index.php?action=<?= $action_path === 'username' ? 'updateusername' : 'updatepassword'; ?>" method="POST" class="flex flex-col gap-6">
    
  <?php if ($action_path === 'username'): ?>
    <div>
        <input name="username" required autofocus="true" type="text" placeholder="New username" class="flex-1 px-4 py-2 border rounded-lg  bg-gray-800 text-white w-full" />
    </div>
  <?php else: ?>
    <div>
        <input name="password-1" required autofocus="true" type="password" placeholder="New Password" class="flex-1 px-4 py-2 border rounded-lg  bg-gray-800 text-white w-full">
    </div>
    <div>
        <input name="password-2" required type="password" placeholder="Repeat Password" class="flex-1 px-4 py-2 border rounded-lg  bg-gray-800 text-white w-full">
    </div>
  <?php endif; ?>
    
    <button type="submit" class="inline-block max-w-[100px] px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Update</button>

  </form>

  <!-- OUTPUT ERRORS -->
    <?php if (isset($_SESSION['error_msg_update'])): ?>
        <div class="bg-gray-900 border border-red-400 text-red-700 px-4 py-3 rounded-md mt-4" role="alert">
            <strong class="font-bold">Error: </strong>
            <span class="block sm:inline"><?php echo $_SESSION['error_msg_update']; ?></span>
        </div>
        <?php unset($_SESSION['error_msg_update']); ?>
    <?php endif; ?>
</div>
