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

            // HANDLE IMAGE UPLOADS
            // move uploaded img from temp loc to dir in my proj
            if ($cover_image['size'] > 0) {
                // set target/final dir
                $target_dir = __DIR__ . '/../uploads/';  // uploads must already exist, w/ writing permissions

                // extract file extension
                $extension = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
                
                // to make names unique
                $timestamp = time();

                // name resulting file
                $filename = "post-image--$timestamp.$extension";
                
                // set final path
                $target_file = $target_dir . $filename;

                // move upload to final path
                // move_uploaded_file($_FILES['cover_image']['tmp_name'], $target_file);

                // Directly compress + save from tmp_name
                // $this->compress_image($_FILES['cover_image']['tmp_name'], $target_file);  
                $this->compress_image($_FILES['cover_image'], $target_file);  
            }

            // push to db 
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
            $cover_image_flag = $_POST['cover_image_flag'];

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
            // HANDLE IMAGE UPLOADS
            // move uploaded img from temp loc to dir in my proj
            if ($cover_image && $cover_image['size'] > 0) {
                // set target/final dir
                $target_dir = __DIR__ . '/../uploads/';  // uploads must already exist, w/ writing permissions

                // extract file extension
                $ext = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
                
                // to make names unique
                $timestamp = time();

                // name resulting file
                $filename = "post-image--$timestamp.$ext";
                
                // set final path
                $target_file = $target_dir . $filename;

                // move upload to final path
                // move_uploaded_file($_FILES['cover_image']['tmp_name'], $target_file);

                // Directly compress + save from tmp_name
                // $this->compress_image($_FILES['cover_image']['tmp_name'], $target_file);
                $this->compress_image($_FILES['cover_image'], $target_file);
                
                $target_file = substr($target_file, 37); // 37 to slice out the absolute path
            } else $target_file = null;
            
            // push to db 
            $db->edit_post($title, $body, $categories, $target_file, $visibility, $user_id, $post_id, $cover_image_flag);
            // header('Location: /php-crash/php-projs/06-blogger/public/home.php');
            header("Location: ../public/post.php?postid=$post_id");
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

        private function redirect_with_error (string $msg_type, string $msg, string $page) {
            $_SESSION[$msg_type] = $msg;
            header("Location: $page");
            exit();
        }

        // ===========================

        public function add_comment ($user_id, $post_id) {
            global $val;
            global $db;

            // get data
            $comment_body = trim($_POST['body']);
            $user_id = trim($user_id);
            $post_id = trim($post_id);
            
            // validate
            // $has_empty_field = $val->has_empty_field([$comment_body, $user_id, $post_id]);
            $has_empty_field = $val->has_empty_field([$comment_body]);
            if ($has_empty_field) {
                $this->redirect_with_error('error_comment', 'Comment body cannot be empty!', "../public/post.php?postid=$post_id");
            }

            // push to db
            $db->add_comment($post_id, $user_id, $comment_body);

            // redirect to the same post page
            header("Location: /php-crash/php-projs/06-blogger/public/post.php?postid=$post_id");
        }

        // ===========================

        public function delete_comment ($user_id, $comment_id, $post_id) {
            global $db;

            $db->delete_comment($user_id, $comment_id);

            header("Location: /php-crash/php-projs/06-blogger/public/post.php?postid=$post_id");
            exit();
        }

        // ===========================

        private function compress_image (array $img, string $destination, int $quality = 75): bool {
            $extension = explode('/', $img['type'])[1];   // extract file extension from MIME type

            switch ($extension) {
                case 'png':
                    $image = imagecreatefrompng($img['tmp_name']); // load PNG from temp upload
                    $result = imagepng($image, $destination, 6);  // save PNG with compression lvl 6 --> 0 (no compression) – 9 (max compression)
                    break;

                case 'gif':
                    $image = imagecreatefromgif($img['tmp_name']);  // load GIF from temp upload
                    $result = imagegif($image, $destination);  // save GIF (no compression available)
                    break;

                case 'jpeg':
                case 'jpg':
                default:
                    $image = imagecreatefromjpeg($img['tmp_name']); // load JPEG from temp upload
                    $result = imagejpeg($image, $destination, $quality);  // save JPEG with quality 0–100
                    break;
            }

            imagedestroy($image);  // free memory used by the image resource
            return $result;  // return true on success, false on failure
        }
    }