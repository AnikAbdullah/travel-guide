<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../helpers/functions.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/ProfileController.php';
require_once __DIR__ . '/../controllers/WishlistController.php';

$pdo = require __DIR__ . '/../config/database.php';
restore_remember_me($pdo);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$basePath = rtrim(app_config()['app']['base_url'], '/');
$route = substr($uri, strlen($basePath));
$route = $route === false ? '/' : $route;
$route = $route === '' ? '/' : $route;
$method = $_SERVER['REQUEST_METHOD'];

$auth = new AuthController($pdo);
$home = new HomeController($pdo);
$profile = new ProfileController($pdo);
$wishlist = new WishlistController($pdo);

switch (true) {
    case $route === '/' && $method === 'GET':
        redirect('/home');

    case $route === '/home' && $method === 'GET':
        $home->index();
        break;

    case $route === '/register' && $method === 'GET':
        $auth->showRegister();
        break;

    case $route === '/register' && $method === 'POST':
        $auth->register();
        break;

    case $route === '/login' && $method === 'GET':
        $auth->showLogin();
        break;

    case $route === '/login' && $method === 'POST':
        $auth->login();
        break;

    case $route === '/logout' && $method === 'GET':
        $auth->logout();
        break;

    case $route === '/profile' && $method === 'GET':
        $profile->show();
        break;

    case $route === '/profile' && $method === 'POST':
        $profile->update();
        break;

    case $route === '/wishlist' && $method === 'GET':
        $wishlist->index();
        break;

    case $route === '/api/wishlist/add' && $method === 'POST':
        $wishlist->add();
        break;

    case $route === '/api/wishlist/remove' && in_array($method, ['POST', 'DELETE'], true):
        $wishlist->remove();
        break;

    default:
        http_response_code(404);
        echo 'Page not found.';
        break;
}
