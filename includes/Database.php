<?php

    declare(strict_types=1);

    class Database {

        private $host = 'localhost';
        private $user = 'root';
        private $pw = '';
        private $db_name = 'php_blogger';

        private $pdo;

        public function __construct () {
            $this->pdo_conn();
        }

        // ================================================================================================

        // make pdo instance
        public function pdo_conn () {
            try {
                $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->db_name;charset=utf8", $this->user, $this->pw);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }      

        // ================================================================================================

        // check if username or email already exist in db
        public function username_email_exists (string $username, string $email): bool {
            $username = trim($username);
            $email = trim($email);
            $result = false;

            $sql = 'SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1';      // limit to 1 record since I care only about "> 0"
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username, $email]);
            
            $fetched = $stmt->fetch(PDO::FETCH_ASSOC);    // fetch one
            if ($fetched) { $result = true; }

            return $result;
        }

        // ================================================================================================

        // check if username or email exists in db
        public function check_username_email (string $usernameEmail): bool {
            $sql = 'SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1'; // limit to 1 since I only care if it's more than 0
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$usernameEmail, $usernameEmail]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? true : false; // return true if exists in db, false if doesn't
        }

        // ================================================================================================

        // on login: check if typed pw was correct
        public function check_password ($username_or_email, $typed_pw): bool {
            $sql = 'SELECT password FROM users WHERE username = ? OR email = ?';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username_or_email, $username_or_email]);

            $fetched_pw = $stmt->fetchColumn(); // fetch the password hash directly, the string directly

            $check_result = password_verify($typed_pw, $fetched_pw); // password_verify compares PLAIN pw to STORED HASH and returns boolean

            return $check_result;
        }

        // ================================================================================================

        public function create_user (string $username, string $email, string $password) {
            $sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);
            $stmt->execute();

            return $this->pdo->lastInsertId(); // return the auto-increment ID -- get the newly created user ID
        }  

        // ================================================================================================

        // get user id
        public function get_user_id ($username_or_email) {   
            $sql = 'SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username_or_email, $username_or_email]);

            $fetched_id = $stmt->fetchColumn(); // fetch id directly, just the string

            return $fetched_id;
        }

        // ================================================================================================

        public function get_user_posts ($user_id) {
            $sql = 'SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // ================================================================================================

        // fetch num of comments to each post
        public function get_user_posts_comments ($user_id) {
            $sql = "SELECT posts.id, COUNT(comments.id) AS count 
                    FROM posts 
                    LEFT JOIN comments ON posts.id = comments.post_id 
                    WHERE posts.user_id = ? 
                    GROUP BY posts.id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // ================================================================================================

        public function get_all_posts () {
            $sql = 'SELECT * FROM posts ORDER BY created_at DESC';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // ================================================================================================
        
        public function create_post ($title, $body, $categories, $image_path, $visibility, $user_id) {
            $sql = "INSERT INTO posts (title, body, categories, image_path, visibility, user_id) VALUES (:title, :body, :categories, :image_path, :visibility, :user_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":body", $body);
            $stmt->bindParam(":categories", $categories);
            $stmt->bindParam(":image_path", $image_path);
            $stmt->bindParam(":visibility", $visibility);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
        }
        
        // ================================================================================================

        public function delete_post ($user_id, $post_id) {
            $sql = 'DELETE FROM posts WHERE id = :id AND user_id = :user_id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":id", $post_id);
            $stmt->execute();
        }

        // ================================================================================================

        public function get_user_post ($user_id, $post_id) {
            $sql = 'SELECT * FROM posts WHERE id = :id AND user_id = :user_id LIMIT 1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":id", $post_id);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // ================================================================================================

        public function get_post ($post_id) {
            $sql = 'SELECT posts.id, posts.title, posts.body, posts.categories, posts.image_path, posts.visibility, posts.user_id, posts.created_at, posts.modified_at, users.username
            FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE posts.id = :id LIMIT 1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":id", $post_id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // ================================================================================================

        public function edit_post ($title, $body, $categories, $cover_image, $visibility, $user_id, $post_id, $cover_image_flag) {
            if ($cover_image_flag === 'keep-current') {
                // do not upd image_path
                $sql = 'UPDATE posts SET title = :title, body = :body, categories = :categories, visibility = :visibility WHERE id = :id AND user_id = :user_id';
            } elseif ($cover_image_flag === 'delete-existing') {
                // upd image_path to null
                $sql = 'UPDATE posts SET title = :title, body = :body, categories = :categories, image_path = NULL, visibility = :visibility WHERE id = :id AND user_id = :user_id';
            } elseif ($cover_image_flag === 'upload-new') {
                // upd image_path to new img path
                $sql = 'UPDATE posts SET title = :title, body = :body, categories = :categories, image_path = :image_path, visibility = :visibility WHERE id = :id AND user_id = :user_id';
            }

            $stmt = $this->pdo->prepare($sql);
            
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":body", $body);
            $stmt->bindParam(":categories", $categories);

            // echo "db->edit_post: ";
            // echo $cover_image_flag;
            // exit();

            if ($cover_image_flag === 'upload-new') {
                $stmt->bindParam(":image_path", $cover_image);
            }

            $stmt->bindParam(":visibility", $visibility);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":id", $post_id);
            $stmt->execute();
        }

        // ================================================================================================

        public function fetch_comments ($post_id) {
            $sql = 'SELECT comments.id, comments.post_id, comments.user_id, comments.body, comments.created_at, users.username FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE comments.post_id = ?';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$post_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // ================================================================================================

        public function add_comment ($post_id, $user_id, $body) {
            $sql = 'INSERT INTO comments (post_id, user_id, body) VALUES (?, ?, ?)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$post_id, $user_id, $body]);
        }

        // ================================================================================================

        public function delete_comment ($user_id, $comment_id) {
            $sql = 'DELETE FROM comments WHERE id = ? AND user_id = ?';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$comment_id, $user_id]);
        }

        // ================================================================================================

        // get all published posts of all users
        public function get_num_of_posts () {
            $sql = 'SELECT COUNT(*) AS count FROM posts WHERE visibility = 1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // ================================================================================================

        // get all published posts of all users -- and unpublished posts of logged in user
        public function get_num_of_posts_loggedin ($user_id) {
            $sql = 'SELECT COUNT(*) AS count FROM posts WHERE visibility = 1 OR (visibility = 0 AND user_id = ?)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // ================================================================================================

        public function get_posts_for_page ($page, $posts_per_page, $user_id) {
            $start_from = 0;
            $posts_per_page = (int) $posts_per_page;

            if ($page > 1) { $start_from = ($page - 1) * $posts_per_page; }

            // fetch all published posts BUT fetch drafted posts only of passed user

            $additional_condition = !$user_id ? '' : "OR (visibility = 0 AND user_id = " . htmlspecialchars((string) $user_id) . ")";
            
            $sql = "SELECT * FROM posts 
                    WHERE visibility = 1 $additional_condition
                    ORDER BY created_at DESC 
                    LIMIT $start_from, $posts_per_page";  // limit params cannot be bound as placeholders
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // ================================================================================================

        public function get_username ($user_id) {
            $sql = 'SELECT username FROM users WHERE id = ? LIMIT 1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchColumn();
        }

        // ================================================================================================

        public function update_username ($user_id, $new_username) {
            $sql = "UPDATE users SET username = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$new_username, $user_id]);
        }

        // ================================================================================================

        public function update_password ($user_id, $new_pw) {
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$new_pw, $user_id]);
        }
    }