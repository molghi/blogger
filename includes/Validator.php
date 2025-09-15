<?php

    declare(strict_types=1);

    class Validator {

        // check if any empty fields
        public function has_empty_field (array $arr): bool {
            $result = false;
            foreach($arr as $item) {
                if (trim($item) === '') {
                    $result = true;
                    break;
                }
            }
            return $result;
        }

        // ================================================================================

        // check if pw's long enough and match
        public function are_passwords_good (string $pw1, string $pw2): bool {
            $pw_min_length = 3;
            $pw1 = trim($pw1);
            $pw2 = trim($pw2);
            $result = true;

            // check if longer than min length
            if (strlen($pw1) < $pw_min_length || strlen($pw2) < $pw_min_length) {
                $result = false;
            }
            // check if same
            elseif ($pw1 !== $pw2) {
                $result = false;
            }
            return $result;
        }

        // ================================================================================

        public function is_title_good (string $title): bool {
            $title = trim($title);
            $result = true;
            if (strlen($title) > 255) {
                $result = false;
            }
            return $result;
        }

        // ================================================================================

        // check if username doesn't start with num and not too long
        public function is_username_valid (string $username): bool {
            $username = trim($username);
            $result = true; 

            // check if starts with num
            if (ctype_digit($username[0])) {   // check if first char = digit
                $result = false; 
            }

            // check if not too long
            elseif (strlen($username) > 25) {
                $result = false;
            }

            return $result;
        }

        // ================================================================================

        // check if email is valid email
        public function is_email_valid (string $email): bool {
            $email = trim($email);
            $result = true; 
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $result = false; 
            }

            return $result;
        }

        // ================================================================================

        // check that $num is either int or float
        public function is_valid_number ($num): bool {
            $is_int = filter_var($num, FILTER_VALIDATE_INT) !== false;        // ensure 0 or 0.0 is treated as valid
            $is_float = filter_var($num, FILTER_VALIDATE_FLOAT) !== false;    // ensure 0 or 0.0 is treated as valid
            return $is_int || $is_float;
        }

        // ================================================================================

        // check that category is existing category
        public function is_valid_category (string $cat): bool {
            $permitted_categories = ['income', 'food', 'transport', 'entertainment', 'other'];
            $result = true;
            if (!in_array(strtolower($cat), $permitted_categories)) { $result = false; }
            return $result;
        }

        // ================================================================================

        // check that date is a valid date
        public function is_valid_date (string $passed_date):bool {
            $d = DateTime::createFromFormat('Y-m-d', $passed_date);  // use PHP’s DateTime class to parse
            return $d && $d->format('Y-m-d') === $passed_date;       // return true if in $d it didn't return false, and if format fn returned the same as what was passed
        }

        // ================================================================================

        public function is_body_okay (string $body):bool {
            $result = true;

            if (strlen($body) > 10000) {
                $result = false;
            }

            return $result;
        }

        // ================================================================================

        public function is_visibility_okay ($vis_value):bool {
            $result = true;

            $accepted = ['0', '1'];
            
            
            if (!in_array($vis_value, $accepted)) {
                $result = false;
            }

            return $result;
        }

        // ================================================================================

        // allow only specific characters:  letters, numbers, parentheses, square brackets, commas, periods, dash, whitespace, and ! ' " # $ % : ; &)
        public function is_text_field_okay(string $value): bool {
            return preg_match('/^[a-zA-Z0-9\s\(\)\[\],\.\-!\'"#\$%:;&]*$/u', $value) === 1;
        }

        // ================================================================================

        public function is_img_okay ($img): bool {
            $result = true;

            // Check for upload errors
            if ($img['error'] !== UPLOAD_ERR_OK) return false;

            // Check MIME type
            if (!str_contains($img['type'], 'image/')) {
                $result = false;
            }
            // Check allowed image formats
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
            // if (!in_array(explode('/', $img['type'])[1], $allowed)) {$result = false;}
            if (!in_array($ext, $allowed)) { return false; }

            // Check size
            $max_size = 5 * 1024 * 1024; // 5 MB in bytes
            if ($img['size'] > $max_size) {
                $result = false;
            }
            return $result;
        }
    }