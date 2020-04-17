<?php
ini_set('display_errors', 1);
ini_set('display_startup_error', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';


use Illuminate\Database\Capsule\Manager as Capsule;
use Aura\Router\RouterContainer;

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'php-class',
    'username'  => 'root',
    'password'  => '',
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
    'action' => 'getAddJobAction'
]);
$map->post('saveJobs', '/php-class/jobs/add', [
    'controller' => 'App\Controllers\JobsController',
    'action' => 'getAddJobAction'
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
    $controller = new $controllerName;
    $response = $controller->$actionName($request);
    echo $response->getBody();
}

?>
