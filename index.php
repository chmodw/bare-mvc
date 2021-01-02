<?php

/**
 * check if the url has parameters. if not assign a empty array
 */
$url = isset($_SERVER['PATH_INFO']) ? explode('/', $_SERVER['PATH_INFO']) : ["index", "index", ""];

/**
 * Getting the controller name
 */
$controller = strtolower($url[0]);

/**
 * Getting the controller method
 * if the method not present default method "index" will called
 * every controller should have a index method
 */
$action = isset($url[1]) ? $url[1] : 'index';

/**
 * Getting the rest of the url as parameters
 */
$params = array_slice($url, 2);

/**
 * Check if the controller, model and view files exists
 */
$controller_file = __DIR__ . '/Controllers/' . ucfirst($controller) . '_controller.php'; // Index_controller.php
$model_file = __DIR__ . '/Models/' . ucfirst($controller) . '_model.php'; // Index_model.php
$view_file = __DIR__ . '/Views/' . $controller . '_view.php'; // index_view.php

/**
 * Needs all the three files
 */
if (file_exists($controller_file) && file_exists($model_file) && file_exists($view_file)) {

    require_once $controller_file;

    $controller = ucfirst($controller);

    $controllerObj  = new $controller();

    if (is_callable(array($controllerObj, $action))) {
        return print($controllerObj->$action());
    }
}

/**
 * return with error if the requested page not found
 */
header('HTTP/1.1 404 Not Found');
die('404 - Requested page not found');
