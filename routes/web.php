<?php

require_once 'controllers/BaseController.php';
require_once 'controllers/ClientController.php';
require_once 'controllers/AddressController.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/AuthController.php';
require_once 'models/Client.php';
require_once 'config/config.php';

class Router
{
    private $routes = [];

    public function add($method, $uri, $handler)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $this->convertUriToRegex($uri),
            'handler' => $handler
        ];
    }

    private function convertUriToRegex($uri)
    {
        return preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $uri);
    }

    // trata as rotas para definir corretamente as views e controllers
    public function dispatch($uri, $method)
    {
        foreach ($this->routes as $route) {
            if (preg_match("#^{$route['uri']}$#", $uri, $matches) && $route['method'] === $method) {
                array_shift($matches); 
                $handler = $route['handler'];
                if (is_callable($handler)) {
                    call_user_func_array($handler, $matches);
                } else {
                    list($controller, $action) = explode('@', $handler);
                    $controllerInstance = new $controller();
                    call_user_func_array([$controllerInstance, $action], $matches);
                }
                return;
            }
        }
        // Default 404 response
        echo '404 Not Found';
    }
}

// Cria a nova instancia de rotas
$router = new Router();

// Define routes
$router->add('GET',  '/',                          'HomeController@index');
$router->add('GET',  '/kabum/',                    'HomeController@index');
$router->add('GET',  '/kabum/login',               'AuthController@login');
$router->add('POST', '/kabum/authenticate',        'AuthController@authenticate');
$router->add('GET',  '/kabum/logout',              'AuthController@logout');
$router->add('GET',  '/kabum/clients',             'ClientController@list');
$router->add('GET',  '/kabum/clients/create',      'ClientController@create');
$router->add('POST', '/kabum/clients/store',       'ClientController@store');
$router->add('GET',  '/kabum/clients/edit/{id}',   'ClientController@edit');
$router->add('POST', '/kabum/clients/update/{id}', 'ClientController@update');
$router->add('POST', '/kabum/clients/delete/{id}', 'ClientController@delete');
$router->add('POST', '/kabum/address/store',       'AddressController@store');
$router->add('POST', '/kabum/address/delete/{id}', 'AddressController@delete');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$router->dispatch($uri, $method);

