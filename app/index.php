<?php

require_once __DIR__ . '/vendor/autoload.php';

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

function require_auth() {

	header('Cache-Control: no-cache, must-revalidate, max-age=0');
	$has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
	
	if ($has_supplied_credentials) {
		header('HTTP/1.1 401 Authorization Required');
		header('WWW-Authenticate: Basic realm="Access denied"');
        echo 'Not authorized';
		exit;
	}
}

//require_auth();

$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/test', 'test');

    $r->addGroup('/signin', function(RouteCollector $r) {

        $r->get('', handler: 'signin.index');
        $r->post('', 'signin.store');
    });

    $r->addGroup('/tasks', function(RouteCollector $r) {
        $r->get('',       'tasks.index');
        $r->get('/create', 'tasks.create');
        $r->post('',       'tasks.store');
        $r->get('/{task:.+}', 'tasks.show');
        $r->addRoute(['POST', 'PUT', 'PATCH'], '/{task:\d+}', 'tasks.update');
    });
    
});

$routeInfo = $dispatcher->dispatch(...getMethodUri());

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo 'Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo 'Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $response = getHandler(handler: $routeInfo[1])($routeInfo[2]);
        echo $response;
        break;
}

function getHandler(string $handler): callable {

    list($controller, $method) = explode('.', $handler);

    $controllerName = '\UI\Controller\\' . ucfirst($controller).'Controller';

    $controller = new $controllerName(__DIR__.'/templates');

    return fn($vars) => $controller->$method($vars);
}

function getMethodUri(): array {

    return array($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
}