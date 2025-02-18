<?php

require_once __DIR__."/../vendor/autoload.php";
require __DIR__.'/../config/config.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Token {

    private $secret;
    private $algorithm;

    public function __construct() {
        /*
         * Initialize parameters
         */
        $this->algorithm = ALGORITHM;
        $this->secret = SECRET_KEY;
    }

    public function generateToken($id, $email, $name, $date) {
        $payload = [
            'iss' => "Issuer",
            'aud' => "Issuer",
            'iat' => time(),
            'exp' => time() + (60 * 60),
            'data' => [
                'id' => $id,
                'email' => $email,
                'name' => $name,
                'date' => $date
            ]
        ];

        return JWT::encode($payload, $this->secret, $this->algorithm);
    }

    public function verifyToken($token) {
        try {
            if (!$token) {
                $result = ["error" => "Unauthorized"];
            } else {
                $decoded = JWT::decode($token, new Key($this->secret, $this->algorithm));
                $result = $decoded;
            }
        } catch (Exception $e) {
            $result = ['error' => $e->getMessage()];
        }
        return json_encode($result);
    }

    public function authorize() {
        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'];
        $decoded = json_decode($this->verifyToken($authHeader), true);

        if (!isset($authHeader)) {
            if (isset($decoded['error'])) {
                $code = 200;
                http_response_code($code);
                $result = ["error" => $decoded['error']];
            } else {
                $code = 404;
                http_response_code($code);
                $result = ["status" => $code, "message" => "Undefined error"];
            }
        } else {
            if (isset($decoded['error'])) {
                $code = 401;
                http_response_code($code);
                $result = ["status" => $code, "error" => $decoded['error']];
            } else {
                $code = 200;
                http_response_code($code);
                $result = ["status" => $code, "message" => "Access granted", "data" => $decoded['data']];
            }
        }

        return json_encode($result);
    }
}
