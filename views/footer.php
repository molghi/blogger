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
    // submit GET form to some page
    function submitGetForm(actionString) {      
        const form = document.createElement("form"); form.method = "GET";
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
        document.querySelector('.post-block').addEventListener('click', function(e) {
            if (!e.target.closest('.delete-post')) return;
            const title = e.target.closest('.post-block').querySelector('.post-title').textContent.trim();
            const body = e.target.closest('.post-block').querySelector('.post-body').textContent.trim().slice(0,50) + '...';
            const created = e.target.closest('.post-block').querySelector('.post-created').textContent.trim();
            const answer = confirm(`Are you sure you want to delete this post?\n\nTitle: ${title}\nBody: ${body}\nCreated: ${created}\n\nThis action cannot be undone.`);
            if (!answer) return;
            const postId = e.target.closest('.post-block').dataset.postId;
            submitPostForm(`../public/index.php?action=deletepost&postid=${postId}`);
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

    if (document.querySelector('.delete-comment')) {
        document.querySelector('.comments').addEventListener('click', function(e) {
            if (!e.target.closest('.delete-comment')) return;
            const commentText = e.target.closest('.comment').querySelector('.comment-text').textContent.trim().slice(0,50) + '...';
            const answer = confirm(`Are you sure you want to delete this comment?\n\nComment: ${commentText}\n\nThis action cannot be undone.`);
            if (!answer) return;
            const commentId = e.target.closest('.comment').dataset.commentId;
            const postId = document.querySelector('.post-block').dataset.postId;
            submitPostForm(`../public/index.php?action=deletecomment&commentid=${commentId}&postid=${postId}`)
        })
    }

    // delete cover image
    if (document.querySelector('.delete-cover')) {
        document.querySelector('.delete-cover').addEventListener('click', function(e) {
            // e.target.closest('form').querySelector('input#cover_image').setAttribute('value', '');
            e.target.closest('form').querySelector('#cover_image').removeAttribute('name');
            e.target.closest('form').querySelector('#cover_image').removeAttribute('value');
            e.target.remove();
        })
    }

    // implement pagination
    if (document.querySelector('.pagination')) {
        document.querySelector('.pagination').addEventListener('click', function(e) {
            if (!e.target.closest('button')) return;
            const clickedPage = e.target.closest('button').dataset.page;
 
            if (!isNaN(+clickedPage)) {
                location.href = `../public/home.php?current_page=${clickedPage}`;
            } else {
                const currentPage = location.search ? +location.search.split('=')[1] : 1;
                const clickedBtn = e.target.closest('button').dataset.page;
                const pageToGo = clickedBtn === 'prev' ? currentPage - 1 : currentPage + 1;
                location.href = `../public/home.php?current_page=${pageToGo}`;
            }
        })
    }
</script>
</body>
</html>