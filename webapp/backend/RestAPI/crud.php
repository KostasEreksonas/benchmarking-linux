<?php
require_once "classes/Crud.php";

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

$crud = new Crud();

switch ($method) {
    case 'GET':
        $benchmark = $_GET['benchmark'];
        $id = $_GET['id'];
        $username = $_GET['username'];
        if (isset($benchmark) && !isset($id) && !isset($username)) {
            $result = $crud->loadResults($benchmark);
        } elseif (isset($benchmark) && isset($id) && !isset($username)) {
            $result = $crud->loadResult($benchmark, $id);
        } elseif (isset($benchmark) && isset($username) && !isset($id)) {
            $result = $crud->userResults($benchmark, $username);
        } else {
            $code = 422;
            http_response_code($code);
            $result = $crud->showStatus($code, "Error loading data");
        }
        echo $result;
        break;

    case 'POST':
        $username = $input['username'];
        $bench_name = $input['bench_name'];
        $bench_type = $input['bench_type'];
        $model = $input['hw_model'];
        $frequency = $input['frequency'];
        $average = $input['average'];
        $fastest = $input['fastest'];
        $result = $crud->postResult($bench_name, $bench_type, $model, $frequency, $average, $fastest, $username);
        echo $result;
        break;

    case 'PUT':
        $id = $_GET['id'];
        $username = $input['username'];
        $bench_name = $input['bench_name'];
        $bench_type = $input['bench_type'];
        $model = $input['hw_model'];
        $frequency = $input['frequency'];
        $average = $input['average'];
        $fastest = $input['fastest'];
        $result = $crud->updateResult($id, $bench_name, $bench_type, $model, $frequency, $average, $fastest, $username);
        echo $result;
        break;

    case 'DELETE':
        $benchmark = $_GET['benchmark'];
        $id = $_GET['id'];
        $result = $crud->deleteResult($benchmark, $id);
        echo $result;
        break;

    default:
        $crud->defaultMethod();
        break;
}
