<?php
require_once "classes/Auth.php";

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

$auth = new Auth();

switch ($method) {
  case 'GET':
    if (isset($_GET['username'])) {
      $username = $_GET['username'];
      $result = $auth->getUser($method, $username);
    } else {
      $code = 404;
      http_response_code($code);
      $result = $auth->showStatus($code, "User does not exist", "");
    }
    echo $result;
    break;

  case 'POST':
    $action = $input['action'];
    $username = $input['username'];
    $email = $input['email'];
    $password = $input['password'];
    if ($action === 'login') {
      echo $auth->login($method, $email, $password);
    } elseif ($action === 'register') {
      echo $auth->register($method, $username, $email, $password);
    } else {
      $code = 404;
      http_response_code($code);
      echo $auth->showStatus($code, "Undefined Action", "");
    }
    break;

  case 'PUT':
    $id = $_GET['id'];
    $name = $input['name'];
    $email = $input['email'];
    $password = $input['password'];
    echo $auth->updateUser($method, $name, $email, $password);
    break;

  case 'DELETE':
    $id = $_GET['id'];
    echo $auth->deleteUser($method, $id);
    break;
}
