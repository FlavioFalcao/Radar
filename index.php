<?php
/**
 * index.php
 *
 * Captures all page requests using .htaccess rewrite rule. Autoloads classes,
 * processes and routes requests to controllers using Router class.
 *
 * PHP Version 5
 *
 * @category Router
 * @package  Router
 * @author   Brad Melanson <bradmelanson@icloud.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/bradJM
 */

// autoload classes
spl_autoload_register(
    function ($class_name) {

        if (file_exists('classes/' . $class_name . '.php')) {
            include 'classes/' . $class_name . '.php';
        } elseif (file_exists('classes/controllers/' . $class_name . '.php')) {
            include 'classes/controllers/' . $class_name . '.php';
        } elseif (file_exists('classes/models/' . $class_name . '.php')) {
            include 'classes/models/' . $class_name . '.php';
        }

    }
);

// start a session to handle authentication
session_start();

// set the default timezone to prevent warnings when using date() function
date_default_timezone_set('America/Halifax');

// require compatibility library for PHP 5.5 password hashing API
require_once 'vendor/password.php';

// include helper functions
require_once 'helpers.inc.php';

// create a request object and store the requested URL
$request = new Request;

// get the requested path ('/' as default for index page)
if (isset($_SERVER['PATH_INFO'])) {
    $request->path = $_SERVER['PATH_INFO'];
} else {
    $request->path = '/';
}

// check the HTTP verb
$request->verb = $_SERVER['REQUEST_METHOD'];

// route the request
$router = new Router;
$response = $router->route($request);

