<?php

    class AuthController {

        private $index_page = '/php-crash/php-projs/06-blogger/public/index.php';    // entry page
        private $home_page = '/php-crash/php-projs/06-blogger/public/home.php';
        private $upd_form_page = '/php-crash/php-projs/06-blogger/public/change-details.php';
        private $panel_page = '/php-crash/php-projs/06-blogger/public/user_panel.php';
        private $db = null;
        private $val = null;

        public function __construct($db, $val) { 
            $this->db = $db; 
            $this->val = $val; 
        }

        // ================================================================================================================

        public function signup () {
            // get form data
            $username = trim($_POST['username']);
            $email = strtolower(trim($_POST['email']));
            $password = trim($_POST['password']);
            $password_repeat = trim($_POST['password-repeat']);

            // validate

            // check that all fields are filled
            $has_empty_field = $this->val->has_empty_field([$username, $email, $password, $password_repeat]);
            if ($has_empty_field) { 
                $this->redirect_with_error('error_msg_signup', 'Fill out all fields!', $this->index_page);
            }

            // check that pw's long enough & match
            $are_passwords_good = $this->val->are_passwords_good($password, $password_repeat);
            if (!$are_passwords_good) {
                $this->redirect_with_error('error_msg_signup', 'Passwords must match & be at least 3 chars long!', $this->index_page);
            }
            
            // check valid username: doesnt start with num, not too long
            $is_username_valid = $this->val->is_username_valid($username);
            if (!$is_username_valid) {
                $this->redirect_with_error('error_msg_signup', 'Username mustn\'t start with a number or be longer than 25 chars!', $this->index_page);
            }
            
            // check valid email
            $is_email_valid = $this->val->is_email_valid($email);
            if (!$is_email_valid) {
                $this->redirect_with_error('error_msg_signup', 'Email must be a valid email!', $this->index_page);
            }

            // check if username & email exist in db 
            $username_email_exists = $this->db->username_email_exists($username, $email);
            if ($username_email_exists) {
                $this->redirect_with_error('error_msg_signup', 'That username or email is already used!', $this->index_page);
            }

            // if all good, run query to make new entry in db --> in 'users' table -- and hash pw
            $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
            $user_id = $this->db->create_user($username, $email, $hashed_pw);   // create user returns new user id
            
            unset($_SESSION['error_msg_signup']);

            // log user in -- set some token & render sth different
            $_SESSION['user_id'] = $user_id;                                                  // set some token
            header("Location: $this->home_page"); 
            exit();
        }

        // ================================================================================================================

        public function login () {

            // get form data -- no need to sanitize cuz Im not outputting to browser
            $username_or_email = strtolower(trim($_POST['usernameEmail']));
            $password = trim($_POST['pw']);

            // check if $username_or_email exists in db
            $user_exists = $this->db->check_username_email($username_or_email);
            if (!$user_exists) {   // if not, return error 
                $this->redirect_with_error('error_msg_login', 'Username or email doesn\'t exist in the database!', $this->index_page);
            }

            // if exists, check pw
            $is_password_correct = $this->db->check_password($username_or_email, $password);
            if (!$is_password_correct) { 
                $this->redirect_with_error('error_msg_login', 'Invalid credentials!', $this->index_page);
            }
            
            // if all good, log 'em in
            unset($_SESSION['error_msg_login']);
            $user_id = $this->db->get_user_id($username_or_email);         // query db, get only user id
            $_SESSION['user_id'] = $user_id;                         // set some token
            header("Location: $this->home_page");  
            exit();
        }

        // ================================================================================================================

        public function redirect_with_error (string $msg_type, string $msg, string $page) {
            $_SESSION[$msg_type] = $msg;
            header("Location: $page");
            exit();
        }
        
        // ================================================================================================================

        public function upd_username ($user_id, $new_username) {
            global $db;
            global $val;
            
            // validate
            $has_empty_field = $val->has_empty_field([$new_username]);
            if ($has_empty_field) {
                $this->redirect_with_error('error_msg_update', 'Username cannot be empty!', $this->upd_form_page . '?action=username');
            }

            $is_username_valid = $val->is_username_valid($new_username);
            if (!$is_username_valid) {
                $this->redirect_with_error('error_msg_update', 'Username is either too long or starts with a number!', $this->upd_form_page . '?action=username');
            }

            // if errors, redir & output em --> $_SESSION['error_msg_update']

            // if all good, run upd query & redir
            $db->update_username($user_id, $new_username);
            header("Location: $this->panel_page");
        }

        // ================================================================================================================

        public function upd_password ($user_id, $new_pw_1, $new_pw_2) {
            global $db;
            global $val;

            // validate
            $has_empty_field = $val->has_empty_field([$new_pw_1, $new_pw_2]);
            if ($has_empty_field) {
                $this->redirect_with_error('error_msg_update', 'Fill out all fields!', $this->upd_form_page . '?action=password');
            }

            $are_passwords_good = $val->are_passwords_good($new_pw_1, $new_pw_2);
            if (!$are_passwords_good) {
                $this->redirect_with_error('error_msg_update', 'Passwords do not match or are too short!', $this->upd_form_page . '?action=password');
            }

            // if errors, redir & output em --> $_SESSION['error_msg_update']
            
            // if all good, hash it, run upd query & redir
            $hashed_pw = password_hash($new_pw_1, PASSWORD_DEFAULT);
            $db->update_password($user_id, $hashed_pw);
            $_SESSION['pw_upd_msg'] = 'Password updated successfully!';
            header("Location: $this->panel_page");
        }
    }