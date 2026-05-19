<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../helpers/functions.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/ProfileController.php';
require_once __DIR__ . '/../controllers/WishlistController.php';

$conn = require __DIR__ . '/../config/database.php';
restore_remember_me($conn);

$uri      = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$basePath = rtrim(app_config()['app']['base_url'], '/');
$route    = substr($uri, strlen($basePath));
$route    = ($route === false || $route === '') ? '/' : $route;
$method   = $_SERVER['REQUEST_METHOD'];

$auth     = new AuthController($conn);
$home     = new HomeController($conn);
$profile  = new ProfileController($conn);
$wishlist = new WishlistController($conn);

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

    // ── Task 2 – Scout (loads ScoutController if merged) ─────────────────────
    case preg_match('#^/scout#', $route):
        $scoutController = __DIR__ . '/../controllers/ScoutController.php';
        if (file_exists($scoutController)) {
            require_once $scoutController;
            $scout = new ScoutController($conn);
            // Route to the right scout method
            if ($route === '/scout/requests' && $method === 'GET')        { $scout->index();       break; }
            if ($route === '/scout/requests/create' && $method === 'GET') { $scout->create();      break; }
            if ($route === '/scout/requests/create' && $method === 'POST'){ $scout->store();       break; }
            if (preg_match('#^/scout/requests/(\d+)/edit$#', $route, $m) && $method === 'GET')  { $scout->edit((int)$m[1]);   break; }
            if (preg_match('#^/scout/requests/(\d+)/edit$#', $route, $m) && $method === 'POST') { $scout->update((int)$m[1]); break; }
            if (preg_match('#^/scout/requests/(\d+)/delete$#', $route, $m)) { $scout->destroy((int)$m[1]); break; }
            if ($route === '/scout/approved' && $method === 'GET')        { $scout->approved();    break; }
        }
        http_response_code(404);
        require __DIR__ . '/../views/errors/404.php';
        break;

    // ── Task 3 – Admin (loads AdminController if merged) ─────────────────────
    case preg_match('#^/admin#', $route):
        $adminController = __DIR__ . '/../controllers/AdminController.php';
        if (file_exists($adminController)) {
            require_once $adminController;
            $admin = new AdminController($conn);
            if ($route === '/admin'                && $method === 'GET')  { $admin->index();                    break; }
            if ($route === '/admin/users'          && $method === 'GET')  { $admin->users();                    break; }
            if ($route === '/admin/posts'          && $method === 'GET')  { $admin->posts();                    break; }
            if ($route === '/admin/comments'       && $method === 'GET')  { $admin->comments();                 break; }
            if (preg_match('#^/admin/users/(\d+)#', $route, $m))          { $admin->userAction((int)$m[1]);     break; }
            if (preg_match('#^/admin/posts/(\d+)#', $route, $m))          { $admin->postAction((int)$m[1]);     break; }
            if (preg_match('#^/admin/comments/(\d+)#', $route, $m))       { $admin->commentAction((int)$m[1]);  break; }
        }
        http_response_code(404);
        require __DIR__ . '/../views/errors/404.php';
        break;

    // ── Task 4 – Browse posts (loads PostController if merged) ───────────────
    case preg_match('#^/posts#', $route) && $method === 'GET':
        $postController = __DIR__ . '/../controllers/PostController.php';
        if (file_exists($postController)) {
            require_once $postController;
            $postCtrl = new PostController($conn);
            if (preg_match('#^/posts/(\d+)$#', $route, $m)) { $postCtrl->show((int)$m[1]); break; }
            $postCtrl->index();
            break;
        }
        // Fallback until Task 4 is merged
        if (is_verified_user()) {
            require __DIR__ . '/../views/home/index.php';
        } else {
            redirect('/home');
        }
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/../views/errors/404.php';
        break;
}
