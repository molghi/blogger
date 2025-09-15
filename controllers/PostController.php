<?php

    class PostController {

        public function add () {
            global $val;
            global $db;
            global $user_id;

            // get form data
            $title = trim($_POST['title']);               // can be empty
            $body = trim($_POST['body']);                 // cannot be empty
            $categories = isset($_POST['categories']) ? trim($_POST['categories']) : null;     // can be empty
            $cover_image = isset($_FILES['cover_image']) && $_FILES['cover_image']['size'] > 0 ? $_FILES['cover_image'] : null;         // can be empty
            $visibility = isset($_POST['visibility']) ? $_POST['visibility'] : '';           // cannot be empty: one of two values

            // validate no empty fields
            $has_empty_field = $val->has_empty_field([$body, $visibility]);
            if ($has_empty_field) {
                $this->redirect_with_error('post_error', 'Post body and visibility fields cannot be empty!', "../public/post-form.php?action=add");
            }

            // validate title is not long
            $is_title_good = $val->is_title_good($title);
            if (!$is_title_good) {
                $this->redirect_with_error('post_error', 'Title is too long!', "../public/post-form.php?action=add");
            }

            // validate body is not too long
            $is_body_okay = $val->is_body_okay($body);
            if (!$is_body_okay) {
                $this->redirect_with_error('post_error', 'Body is too long!', "../public/post-form.php?action=add");
            }

            // validate visibility: strictly 0 or 1
            $is_visibility_okay = $val->is_visibility_okay($visibility);
            if (!$is_visibility_okay) {
                $this->redirect_with_error('post_error', 'Visibility field is unset!', "../public/post-form.php?action=add");
            }

            // validate categories if exist: validate allowed characters (letters, numbers, commas) to prevent injection or malformed data.
            if ($categories) {
                $is_categories_okay = $val->is_text_field_okay($categories);
                if (!$is_categories_okay) {
                    $this->redirect_with_error('post_error', 'Categories field contains invalid characters!', "../public/post-form.php?action=add");
                }
            }

            // validate cover image
            if ($cover_image['size'] > 0) {
                $is_img_okay = $val->is_img_okay($cover_image);
                if (!$is_img_okay) {
                    $this->redirect_with_error('post_error', 'There\'s been a problem with your image!', "../public/post-form.php?action=add");
                }
            }

            // if title empty, make generic title
            if ($title === '') {
                date_default_timezone_set('Etc/GMT-4');
                $today = '\'' . substr(date('Y-m-d'), 2);
                $today .= ' (' . date("D") . ')';
                $title = "Journal Entry $today";
            }

            // if all good:

            // move the uploaded img file from the temporary location to a folder in your project
            if ($cover_image['size'] > 0) {
                // $target_dir = __DIR__ . '/../uploads/';
                // if (!is_dir($target_dir)) { mkdir($target_dir, 0755, true); }
                $target_dir = realpath(__DIR__ . '/..') . '/uploads/';

                if (!file_exists($target_dir)) {
                    if (!mkdir($target_dir, 0755, true)) {
                        die("Failed to create upload directory: $target_dir");
                    }
                }

                if (!is_writable($target_dir)) {
                    die("Upload directory is not writable: $target_dir");
                }
                // $filename = basename($_FILES['cover_image']['name']);
                $ext = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
                $timestamp = time();
                // $filename = "post-image--$timestamp";
                $filename = "post-image--$timestamp.$ext";
                $target_file = $target_dir . $filename;
                // move_uploaded_file($_FILES['cover_image']['tmp_name'], $target_file);
                if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $target_file)) {
                    echo "File uploaded successfully!";
                } else {
                    echo "Failed to upload file.";
                    var_dump(error_get_last()); 
                }
            }

            // push to db 
            // $db->create_post($title, $body, $categories, $cover_image, $visibility, $user_id);
            $target_file = substr($target_file, 37); // 37 to slice out the absolute path
            $db->create_post($title, $body, $categories, $target_file, $visibility, $user_id);

            // redirect to home
            $_SESSION['img'] = $cover_image;
            header('Location: /php-crash/php-projs/06-blogger/public/home.php');
            exit();            
        }

        // ===========================
        
        public function edit ($post_id) {
            global $val;
            global $db;
            global $user_id;

            // get form data
            $title = trim($_POST['title']);               // can be empty
            $body = trim($_POST['body']);                 // cannot be empty
            $categories = isset($_POST['categories']) ? trim($_POST['categories']) : null;     // can be empty
            $cover_image = isset($_FILES['cover_image']) && $_FILES['cover_image']['size'] > 0 ? $_FILES['cover_image'] : null;         // can be empty
            $visibility = $_POST['visibility'];           // cannot be empty: one of two values

            // validate no empty fields
            $has_empty_field = $val->has_empty_field([$body, $visibility]);
            if ($has_empty_field) {
                $this->redirect_with_error('post_error', 'Post body and visibility fields cannot be empty!', "../public/post-form.php?action=add");
            }

            // validate title is not long
            $is_title_good = $val->is_title_good($title);
            if (!$is_title_good) {
                $this->redirect_with_error('post_error', 'Title is too long!', "../public/post-form.php?action=add");
            }

            // validate body is not too long
            $is_body_okay = $val->is_body_okay($body);
            if (!$is_body_okay) {
                $this->redirect_with_error('post_error', 'Body is too long!', "../public/post-form.php?action=add");
            }

            // validate visibility: strictly 0 or 1
            $is_visibility_okay = $val->is_visibility_okay($visibility);
            if (!$is_visibility_okay) {
                $this->redirect_with_error('post_error', 'Visibility field is unset!', "../public/post-form.php?action=add");
            }

            // validate categories if exist: validate allowed characters (letters, numbers, commas) to prevent injection or malformed data.
            if ($categories) {
                $is_categories_okay = $val->is_text_field_okay($categories);
                if (!$is_categories_okay) {
                    $this->redirect_with_error('post_error', 'Categories field contains invalid characters!', "../public/post-form.php?action=add");
                }
            }

            // validate cover image
            if ($cover_image) {
                $is_img_okay = $val->is_img_okay($cover_image);
                if (!$is_img_okay) {
                    $this->redirect_with_error('post_error', 'There\'s been a problem with your image!', "../public/post-form.php?action=add");
                }
            }

            // if title empty, make generic title
            if ($title === '') {
                $today = '\'' . substr(date('Y-m-d'), 2);
                $today .= ' (' . date("D") . ')';
                $title = "Journal Entry $today";
            }

            // if all good, push to db & redirect to home
            $db->edit_post($title, $body, $categories, $cover_image, $visibility, $user_id, $post_id);
            header('Location: /php-crash/php-projs/06-blogger/public/home.php');
            exit();  
        }

        // ===========================
        
        public function delete ($post_id) {
            global $db;
            global $user_id;

            $db->delete_post($user_id, $post_id);
            header('Location: /php-crash/php-projs/06-blogger/public/home.php');
            exit();  
        }

        // ===========================

        public function redirect_with_error (string $msg_type, string $msg, string $page) {
            $_SESSION[$msg_type] = $msg;
            header("Location: $page");
            exit();
        }
    }