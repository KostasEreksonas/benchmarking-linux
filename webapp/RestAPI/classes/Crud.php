<?php

require_once "Database.php";

class Crud {
    protected $db;

    public function __construct() {
        /*
         * Create a database instance
         */
        $this->db = new Database("localhost", "root", "", "results");
    }

    public function showStatus($status, $message) {
        return json_encode(["status" => "$status", "message" => "$message"]);
    }

    public function loadResult($benchmark, $id) {
        /*
         * Load single result of a specified benchmark
         */
        $sql = "SELECT * FROM `$benchmark` WHERE id = $id";
        $this->db->query($sql);
        $result = $this->db->resultSet();
        return json_encode($result);
    }

    public function userResults($benchmark, $username) {
        /*
         * Load benchmark results from a single user
         */
        $sql = "SELECT * FROM `$benchmark` WHERE username = '$username'";
        $this->db->query($sql);
        $result = $this->db->resultSet();
        return json_encode($result);
    }

    public function loadResults($benchmark) {
        /*
         * Load results for specific benchmark
         */
        $sql = "SELECT * FROM `$benchmark`";
        $this->db->query($sql);
        $result = $this->db->resultSet();
        return json_encode($result);
    }

    public function postResult($bench_name, $bench_type, $model, $frequency, $average, $fastest, $username) {
        /*
         * Post result into database
         */
        $sql = "INSERT INTO $bench_name (`bench_name`, `bench_type`, `hw_model`, `frequency`, `average`, `fastest`, `username`) VALUES ('$bench_name', '$bench_type', '$model', '$frequency', '$average', '$fastest', '$username')";
        $this->db->query($sql);
        $this->db->execute();
        return $this->showStatus(200, "$bench_name result uploaded successfully");
    }

    public function updateResult($id, $bench_name, $bench_type, $model, $frequency, $average, $fastest, $username) {
        $sql = "UPDATE `$bench_name` SET `bench_name`='$bench_name', `bench_type`='$bench_type', `hw_model`='$model', `frequency` = '$frequency', `average`='$average', `fastest`='$fastest', `username`='$username' WHERE `id`=$id";
        $this->db->query($sql);
        $this->db->execute();
        return json_encode(["message" => "User $username was updated successfully"]);
    }

    public function deleteResult($benchmark, $id) {
        $data = json_decode($this->loadResult($benchmark, $id), true);
        if ($data['status'] === 404) {
            http_response_code(404);
            $result = $data;
        } else {
            $sql = "DELETE FROM `$benchmark` WHERE `id`=$id";
            $this->db->query($sql);
            $this->db->execute();
            $result = json_encode(["message" => "Result was deleted successfully"]);
        }
        return $result;
    }

    public function defaultMethod(){
        return json_encode(["message" => "Invalid request method"]);
    }
}
