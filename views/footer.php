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

    // prompt on delete post
    if (document.querySelector('.delete-post')) {
        document.querySelector('.posts').addEventListener('click', function(e) {
            if (!e.target.closest('.post')) return;
            if (!e.target.closest('.delete-post')) return;
            const title = e.target.closest('.post').querySelector('.post-title').textContent.trim();
            const body = e.target.closest('.post').querySelector('.post-body').textContent.trim().slice(0,50) + '...';
            const created = e.target.closest('.post').querySelector('.post-created').textContent.trim();
            const answer = confirm(`Are you sure you want to delete this post?\n\nTitle: ${title}\nBody: ${body}\nCreated: ${created}`);
            if (!answer) return;
            const postId = e.target.closest('.post').dataset.postId;
            submitPostForm(`../public/index.php?action=deletepost&post=${postId}`);
        })
    }

    // prompt on Add Post btn click if editing a post
    if (document.querySelector('.add-post-btn')) {
        document.querySelector('.add-post-btn').addEventListener('click', function(e) {
            const onEditPage = location.href.includes('action=edit');
            if (onEditPage) {
                const answer = confirm(`You have unsaved changes.\n\nAre you sure you want to leave this post and add a new one?`);
                if (!answer) {
                    e.preventDefault();
                    return;
                }
            }
        })
    }

    // prompt on Back btn click if editing a post
    if (document.querySelector('.back-btn')) {
        document.querySelector('.back-btn').addEventListener('click', function(e) {
            const onEditPage = location.href.includes('action=edit');
            if (onEditPage) {
                const answer = confirm(`You have unsaved changes.\n\nAre you sure you want to leave this post?`);
                if (!answer) {
                    e.preventDefault();
                    return;
                }
            }
        })
    }
</script>
</body>
</html>