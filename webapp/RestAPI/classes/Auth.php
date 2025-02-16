<?php

require_once "Database.php";
require "Token.php";

class Auth {
    protected $db;
    protected $token;

    public function __construct() {
        /*
         * Create a database and token instances
         */
        $this->db = new Database("localhost", "root", "", "auth");
        $this->token = new Token();
    }

    public function showStatus($status, $message, $token) {
        /*
         * Print a JSON-formatted status message
         */
        if ($token === "") {
            $result = json_encode(["status" => $status, "message" => $message]);
        } else {
            $result = json_encode(["status" => $status, "message" => $message, "token" => $token]);
        }
        return $result;
    }

    public function getUser($method, $username) {
        /*
         * Get information about a single user
         */
        if ($method !== 'GET') {
            $code = 405;
            http_response_code($code);
            $result = $this->showStatus($code, "Method $method not allowed", "");
        } else {
            $sql = "SELECT username,email,created_at FROM `users` WHERE `username` = '$username'";
            $this->db->query($sql);
            $data = $this->db->resultSet();
            if (json_encode($data) === '[]') {
                $code = 404;
                http_response_code($code);
                $result = $this->showStatus($code, "No active user found", "");
            } else {
                $result = json_encode($data[0]);
            }
        }
        return $result;
    }

    public function checkCredentials($data, $password) {
        /*
         * Check if valid login credentials exist in the database
         */
        if (!password_verify($password, $data['password']) || $data === 'null') {
            $code = 400;
            http_response_code($code);
            $result = $this->showStatus($code, "Wrong email and / or password", "");
        } else {
            $code = 200;
            http_response_code($code);
            $token = $this->token->generateToken($data['id'], $data['email'], $data['username'], $data['created_at']);
            $result = $this->showStatus($code, "Login successful", $token);
        }
        return $result;
    }

    public function login($method, $email, $password) {
        /*
         * Login to user account
         */
        if ($method !== 'POST') {
            $code = 405;
            http_response_code($code);
            $result = $this->showStatus($code, "Method $method not allowed", "");
        } else {
            $sql = "SELECT id,email,username,password,created_at FROM `users` WHERE `email` = '$email'";
            $this->db->query($sql);
            $data = $this->db->single();
            $data = json_decode(json_encode($data), true);
            if ($email === "" || $password === "") {
                $code = 400;
                http_response_code($code);
                $result = $this->showStatus($code, "Missing login credentials", "");
            } else {
                $result = $this->checkCredentials($data, $password);
            }
        }
        return $result;
    }

    public function checkEmail($email) {
        /*
         * Check if selected email already is in use
         */
        $sql = "SELECT `email` FROM `users` WHERE `email` = '$email'";
        $this->db->query($sql);
        $data = $this->db->single();
        if (json_encode($data) !== 'false') {
            $code = 409;
            http_response_code($code);
            $result = $this->showStatus($code, "Email $email is already in use", "");
        } else {
            $code = 200;
            http_response_code($code);
            $result = $this->showStatus($code, "Email available", "");
        }
        return $result;
    }

    public function checkUsername($name) {
        /*
         * Check whether username is available to use
         */
        $sql = "SELECT `username` FROM `users` WHERE `username`='$name'";
        $this->db->query($sql);
        $this->db->execute();
        $data = $this->db->resultSet();
        if (json_encode($data) !== '[]') {
            $code = 409;
            http_response_code($code);
            $result = $this->showStatus($code, "Username already in use", "");
        } else {
            $code = 200;
            http_response_code($code);
            $result = $this->showStatus($code, "Username available", "");
        }
        return $result;
    }

    public function hashPassword($password) {
        /*
         * Hash password before storing it in a database
         */
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function register($method, $name, $email, $password) {
        /*
         * Register a new account
         */
        $check_email = json_decode($this->checkEmail($email), true);
        $check_username = json_decode($this->checkUsername($name), true);
        if ($method !== 'POST') {
            $code = 405;
            http_response_code($code);
            $result = $this->showStatus($code, "Method $method not allowed", "");
        } elseif ($check_email['status'] !== 200) {
            $code = $check_email['status'];
            http_response_code($code);
            $result = json_encode($check_email);
        } elseif ($check_username['status'] !== 200) {
            $code = $check_username['status'];
            http_response_code($code);
            $result = json_encode($check_username);
        } elseif (strlen($password) < 6) {
            $code = 400;
            http_response_code($code);
            $result = $this->showStatus($code, "Password must be at least 6 characters long", "");
        } else {
            $password = $this->hashPassword($password);
            $name = str_replace( array( '\'', '"', ':', '!', '?', '{', '}', '[', ']', '(', ')', ',' , ';', '<', '>' ), '', $name);
            $name = str_replace(" ", "", $name);
            $name = strtolower($name);
            $name = ucfirst($name);
            $sql = "INSERT INTO `users` (`username`, `email`, `password`) VALUES ('$name', '$email', '$password')";
            $this->db->query($sql);
            $this->db->execute();
            $code = 200;
            http_response_code($code);
            $result = $this->showStatus($code, "User registered successfully", "");
        }
        return $result;
    }

    public function updateUser($method, $username, $email, $password) {
        /*
         * Update user profile information
         */
        if ($method !== 'PUT') {
            $code = 405;
            http_response_code($code);
            $result = $this->showStatus($code, "Method $method not allowed", "");
        } else {
            $data = $this->getUser($method, $username);
            $x = json_decode($data, true);
            if ($x['status'] === "404") {
                $code = $x["status"];
                http_response_code($code);
                $result = $data;
            } else {
                $password = $this->hashPassword($password);
                $sql = "UPDATE `users` SET `username` = '$username', `email` = '$email', `password` = '$password' WHERE `username` = '$username'";
                $this->db->query($sql);
                $this->db->execute();
                $code = 200;
                http_response_code($code);
                $result = $this->showStatus($code, "User $username info updated successfully", "");
            }
        }
        return $result;
    }

    public function deleteUser($method, $username) {
        /*
         * Delete user from the database
         */
        if ($method !== 'DELETE') {
            $code = 405;
            http_response_code($code);
            $result = $this->showStatus($code, "Method $method not allowed", "");
        } else {
            $data = $this->getUser($method, $username);
            $x = json_decode($data, true);
            if ($x["status"] === "404") {
                $code = $x["status"];
                http_response_code($code);
                $result = $data;
            } else {
                $name = $x[0]["name"];
                $sql = "DELETE FROM `users` WHERE `username` = '$username'";
                $this->db->query($sql);
                $this->db->execute();
                $code = 200;
                http_response_code($code);
                $result = $this->showStatus($code, "User $name deleted successfully", "");
            }
        }
        return $result;
    }
}
