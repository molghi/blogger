<!-- 2 columns layout -->

<div class="container mx-auto flex items-center justify-center py-4">
        <div class="grid md:grid-cols-2 gap-8">
        

            <!-- Sign Up Column -->
            <div class="bg-gray-800 p-8 rounded-lg shadow-lg md:min-w-[300px] max-w-[320px]">
                <h2 class="text-2xl font-bold mb-6 text-indigo-400">New here? Sign Up!</h2>
                <form action="../public/index.php?action=signup" method="POST" class="space-y-4">
                <div>
                    <label class="block mb-1" for="signup-username">Username</label>
                    <input name="username" autofocus="true" id="signup-username" type="text" class="w-full rounded-md border-gray-700 bg-gray-900 text-white p-2 focus:ring focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block mb-1" for="signup-email">Email</label>
                    <input name="email" id="signup-email" type="email" class="w-full rounded-md border-gray-700 bg-gray-900 text-white p-2 focus:ring focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block mb-1" for="signup-password">Password</label>
                    <input name="password" id="signup-password" type="password" class="w-full rounded-md border-gray-700 bg-gray-900 text-white p-2 focus:ring focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block mb-1" for="signup-password-repeat">Repeat Password</label>
                    <input name="password-repeat" id="signup-password-repeat" type="password" class="w-full rounded-md border-gray-700 bg-gray-900 text-white p-2 focus:ring focus:ring-indigo-500">
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold p-2 rounded-md">Sign Up</button>
                </form>

                <!-- OUTPUT SIGNUP ERRORS -->
                <?php if (isset($_SESSION['error_msg_signup'])): ?>
                    <div class="bg-gray-900 border border-red-400 text-red-700 px-4 py-3 rounded-md mt-4" role="alert">
                        <strong class="font-bold">Error: </strong>
                        <span class="block sm:inline"><?php echo $_SESSION['error_msg_signup']; ?></span>
                    </div>
                <?php unset($_SESSION['error_msg_signup']); ?>
                <?php endif; ?>
            </div>
            

            <!-- Login Column -->
            <div class="bg-gray-800 p-8 rounded-lg shadow-lg md:min-w-[300px] max-w-[320px]">
                <h2 class="text-2xl font-bold mb-6 text-green-500">Already a user? Log In!</h2>
                <form action="../public/index.php?action=login" method="POST" class="space-y-4">
                <div>
                    <label class="block mb-1" for="login-username">Username or Email</label>
                    <input name="usernameEmail" id="login-username" type="text" class="w-full rounded-md border-gray-700 bg-gray-900 text-white p-2 focus:ring focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block mb-1" for="login-password">Password</label>
                    <input name="pw" id="login-password" type="password" class="w-full rounded-md border-gray-700 bg-gray-900 text-white p-2 focus:ring focus:ring-indigo-500">
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold p-2 rounded-md">Log In</button>
                </form>

                <!-- OUTPUT LOGIN ERRORS -->
                 <?php if (isset($_SESSION['error_msg_login'])): ?>
                    <div class="bg-gray-900 border border-red-400 text-red-700 px-4 py-3 rounded-md mt-4" role="alert">
                        <strong class="font-bold">Error: </strong>
                        <span class="block sm:inline"><?php echo $_SESSION['error_msg_login']; ?></span>
                    </div>
                <?php unset($_SESSION['error_msg_login']); ?>
                <?php endif; ?>
            </div>

        </div>
</div>