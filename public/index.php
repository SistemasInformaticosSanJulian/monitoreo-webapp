<?php
require '../vendor/autoload.php';

use Bramus\Router\Router;
use App\Controllers\{CUsuario, CSession, CCliente, CConductor, CMovil, CMonitoreo, CViaje};

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: application/x-www-form-urlencoded, multipart/form-data, text/html, application/json');

CSession::getInstance()->start();
if (array_key_exists('usuario', $_SESSION)) {
    $router = new Router();

    $router->get('/', function () {
        $content = '../templates/layouts/blanck.html';
        include '../templates/layouts/base.html';
    });

    $router->mount('/cliente', function () use ($router) {
        $router->get('/', function () {
            $controller = new CCliente();
            $controller->showForm();
        });

        $router->post('/', function () {
            $controller = new CCliente();
            $controller->store($_POST);
        });
    });

    $router->mount('/conductor', function () use ($router) {
        $router->get('/', function () {
            $controller = new CConductor();
            $controller->showForm();
        });

        $router->get('/(\d+)', '\App\Controllers\CConductor@showForm');

        $router->post('/', function () {
            $controller = new CConductor();
            $controller->store($_POST);
        });
    });

    $router->mount('/movil', function () use ($router) {
        $router->get('/', function () {
            $controller = new CMovil();
            $controller->showForm();
        });

        $router->get('/(\d+)', '\App\Controllers\CMovil@showForm');

        $router->post('/', function () {
            $controller = new CMovil();
            $controller->store($_POST);
        });
    });
    $router->mount('/viaje', function () use ($router) {
        $router->get('/', function () {
            $controller = new CViaje();
            $controller->showForm();
        });

        $router->get('/(\d+)', '\App\Controllers\CViaje@showForm');

        $router->post('/', function () {
            $controller = new CViaje();
            $controller->store($_POST);
        });
    });
    $router->mount('/monitoreo', function () use ($router) {
        $router->get('/busqueda', function () {
            $controller = new CMonitoreo();
            $codigo = $_GET['codigo'] ?? '';
            $controller->showForm($codigo);
        });

        $router->get('/encomienda/(\w+)', '\App\Controllers\CMonitoreo@findEncomiendaByCodigo');

        $router->post('/', function () {
            $controller = new CMonitoreo();
            $controller->store($_POST);
        });
    });


    $router->get('/logout', function () {
        $controller = new CUsuario();
        $controller->logout();
    });

    $router->set404(function () {
        header('Location: /');
    });

    $router->run();
} else {
    $pathUrl = $_SERVER['REQUEST_URI'] ?? '';
    $requestMethod = $_SERVER['REQUEST_METHOD'] ?? '';
    $controllerAuth = new CUsuario();
    $controllerMonitoreo = new CMonitoreo();
    $routes = [
        '/' => [
            'GET' => fn() => $controllerAuth->login(),
        ],
        '' => [
            'GET' => fn() => $controllerAuth->login(),
        ],
        '/login' => [
            'GET' => fn() => $controllerAuth->login(),
            'POST' => fn() => $controllerAuth->authenticate([...$_POST]),
        ],
        '/usuario' => [
            'GET' => fn() => $controllerAuth->userRegister(),
            'POST' => fn() => $controllerAuth->createUser([...$_POST]),
        ],
        '/api/monitoreo' => [
            'POST' => fn() => $controllerMonitoreo->updatePosition([...$_POST]),
        ],
    ];

    if (isset($routes[$pathUrl][$requestMethod])) {
        $routes[$pathUrl][$requestMethod]();
    } else {
        http_response_code(404);
        echo "Ruta no encontrada.";
    }
}
