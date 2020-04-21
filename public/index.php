<?php
ini_set('display_errors', 1);
ini_set('display_startup_error', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_NAME'),
    'username'  => getenv('DB_USER'),
    'password'  => getenv('DB_PASSWORD'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);
// var_dump($request->getUri()->getPath());

$routerContainer = new RouterContainer();
$map = $routerContainer->getMap();

$map->get('index', '/php-class/', [
    'controller' => 'App\Controllers\IndexController',
    'action' => 'indexAction'
]);

$map->get('addJobs', '/php-class/jobs/add', [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getAddJobAction',
    'auth' => true
]);
$map->post('saveJobs', '/php-class/jobs/add', [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getAddJobAction'
]);
$map->get('createUser', '/php-class/users/create', [
    'controller' => 'App\Controllers\UsersController',
    'action' => 'createUserAction',
    'auth' => true
]);
$map->post('saveUser', '/php-class/users/create', [
    'controller' => 'App\Controllers\UsersController',
    'action' => 'createUserAction'
]);
$map->get('loginForm', '/php-class/login', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'getLogin'
]);
$map->get('logout', '/php-class/logout', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'getLogout'
]);
$map->post('auth', '/php-class/auth', [
    'controller' => 'App\Controllers\AuthController',
    'action' => 'postLogin'
]);
$map->get('admin', '/php-class/admin', [
    'controller' => 'App\Controllers\AdminController',
    'action' => 'getIndex',
    'auth' => true
]);

$matcher = $routerContainer->getMatcher();

$route = $matcher->match($request);




if(!$route) {
    echo 'No route founded';
}
else {
    $handlerData = $route->handler;
    $controllerName = $handlerData['controller'];
    $actionName = $handlerData['action'];
    $needsAuth = $handlerData['auth'] ?? false;
    $sessionUserId = $_SESSION['userId'] ?? null;
    if($needsAuth && !$sessionUserId) {
        header('location: /php-class/login');
        exit;
    }
    $controller = new $controllerName;
    $response = $controller->$actionName($request);
    foreach($response->getHeaders() as $name => $values) {
        foreach($values as $value) {
            header(sprintf('%s: %s', $name, $value), false);

        }
    }
    http_response_code($response->getStatusCode());
    echo $response->getBody();
}

?>
