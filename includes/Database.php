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
            $sql = 'SELECT * FROM posts WHERE user_id = ?';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // ================================================================================================
    }