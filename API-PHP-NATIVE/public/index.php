<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../src/Router.php';
require_once __DIR__ . '/../src/Controllers/UserController.php';

$router = new Router();
$userController = new UserController();

$router->add('GET', '/api/v1/users', [$userController, 'index']);
$router->add('GET', '/api/v1/users/([0-9]+)', [$userController, 'show']);

$router->run();
?>
