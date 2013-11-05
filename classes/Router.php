<?php
/**
 * Router for all requests to website.
 *
 * PHP Version 5
 *
 * @category Router
 * @package  Router
 * @author   Brad Melanson <bradmelanson@icloud.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/bradJM
 */

/**
 * Router
 *
 * @category Router
 * @package  Router
 * @author   Brad Melanson <bradmelanson@icloud.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/bradJM
 */
class Router
{
    /**
     * route
     *
     * @param Object $request Request object with path and HTTP verb
     *                        information
     *
     * @access public
     * @return mixed $response Return value from controller method or HTTP
     *                         error on bad requests
     */
    public function route($request)
    {
        switch ($request->verb) {

        case 'GET':
            $request->parameters = $_GET;

            if (preg_match('#^/$#', $request->path)) {
                $controller = new PagesController;
                $action = 'index';
            } elseif (preg_match('#^/about$#', $request->path)) {
                $controller = new PagesController;
                $action = 'about';
            } elseif (preg_match('#^/signin$#', $request->path)) {
                $controller = new PagesController;
                $action = 'signin';
            } elseif (preg_match('#^/signup$#', $request->path)) {
                $controller = new PagesController;
                $action = 'signup';
            } elseif (preg_match('#^/signout$#', $request->path)) {
                $controller = new UsersController;
                $action = 'signout';
            } elseif (preg_match('#^/feeds(/\d+)?$#', $request->path)) {
                $controller = new FeedsController;
                $action = 'index';
            } else {
                $controller = new PagesController;
                $action = 'notFound';
            }

            break;

        case 'POST':
        case 'PUT':
        case 'DELETE':
            $request->parameters = $_POST;

            if (preg_match('#^/signin$#', $request->path)) {
                $controller = new UsersController;
                $action = 'signin';
            } elseif (preg_match('#^/signup$#', $request->path)) {
                $controller = new UsersController;
                $action = 'signup';
            } elseif (preg_match('#^/subscribe$#', $request->path)) {
                $controller = new FeedsController;
                $action = 'subscribe';
            } elseif (preg_match('#^/unsubscribe$#', $request->path)) {
                $controller = new FeedsController;
                $action = 'unsubscribe';
            }

            break;

        default:
            header('HTTP/1.0 400 Bad Request');
            $response = 'Unknown Request';

        }

        if ($controller && $action) {
            $response = $controller->$action($request);
        }

        return $response;
    }
}

