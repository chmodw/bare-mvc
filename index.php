<?php

/**
 * check if the url has parameters. if not assign a empty array
 */
$url_params = isset($_SERVER['PATH_INFO']) ? explode('/', $_SERVER['PATH_INFO']) : ["index", "index", ""];

/**
 * Getting the controller name
 */
$controller = $url[0];

/**
 * Getting the controller method
 * if the method not present default method "index" will called
 * every controller should have a index method
 */
$action = isset($url[1]) ? $url[1] : 'index';

// The remain parts are considered as 
// arguments of the method
$requestedParams = array_slice($url, 2);

// Check if controller exists. NB: 
// You have to do that for the model and the view too
$ctrlPath = __DIR__ . '/Controllers/' . $requestedController . '_controller.php';

if (file_exists($ctrlPath)) {

    require_once __DIR__ . '/Models/' . $requestedController . '_model.php';
    require_once __DIR__ . '/Controllers/' . $requestedController . '_controller.php';
    require_once __DIR__ . '/Views/' . $requestedController . '_view.php';

    $modelName      = ucfirst($requestedController) . 'Model';
    $controllerName = ucfirst($requestedController) . 'Controller';
    $viewName       = ucfirst($requestedController) . 'View';

    $controllerObj  = new $controllerName(new $modelName);
    $viewObj        = new $viewName($controllerObj, new $modelName);

    // If there is a method - Second parameter
    if ($requestedAction != '') {
        // then we call the method via the view
        // dynamic call of the view
        print $viewObj->$requestedAction($requestedParams);
    }
} else {
    // header('HTTP/1.1 404 Not Found');
    // die('404 - The file - ' . $ctrlPath . ' - not found');
    // //require the 404 controller and initiate it
    // //Display its view
}
