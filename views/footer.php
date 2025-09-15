</main>

<footer class="bg-black text-gray-400 py-3 text-[14px]">
  <div class="container mx-auto text-center">
    <p>&copy; Sep 2025 PHP Blogger. All rights reserved.</p>
  </div>
</footer>

<!-- JavaScript -->
<script>
    // submit POST form to some page
    function submitPostForm(actionString) {      
        const form = document.createElement("form"); form.method = "POST";
        form.action = actionString;
        document.body.appendChild(form); form.submit();
    }

    // prompt on logout
    if (document.querySelector('.logout-btn')) {
        document.querySelector('.logout-btn').addEventListener('click', function(e) {
            const answer = confirm('Are you sure you want to log out?');
            if (!answer) return;
            submitPostForm('../includes/logout.php');
        })
    }
</script>
</body>
</html>