<?php

require_once "classes/Token.php";
require_once __DIR__."/vendor/autoload.php";

header("Content-Type: application/json");

$token = new Token();

echo $token->authorize();
