<?php
/**
 * Class for displaying static pages
 *
 * PHP Version 5
 *
 * @category Controllers
 * @package  Controllers
 * @author   Brad Melanson <bradmelanson@icloud.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/bradJM
 */

/**
 * PagesController
 *
 * @category Controllers
 * @package  Controllers
 * @author   Brad Melanson <bradmelanson@icloud.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/bradJM
 */
class PagesController
{
    /**
     * index
     *
     * @access public
     * @return View $view Index page for main site
     */
    public function index()
    {
        $feeds = Feed::recent();

        $view = new View('pages/index');
        return $view->render($feeds);
    } // end index() method

    /**
     * about
     *
     * @access public
     * @return View $view About page for main site
     */
    public function about()
    {
        $view = new View('pages/about');
        return $view->render();
    } // end about() method

    /**
     * help
     *
     * @access public
     * @return View $view Help page for main site
     */
    public function help()
    {
        $view = new View('pages/help');
        return $view->render();
    } // end help() method

    /**
     * signin
     *
     * @access public
     * @return View $view Sign in page for main site
     */
    public function signin()
    {
        $data['errors'] = array();
        $data['username'] = '';

        $view = new View('pages/signin');
        return $view->render($data);
    } // end signin() method

    /**
     * signiup
     *
     * @access public
     * @return View $view Sign up page for main site
     */
    public function signup()
    {
        if (User::current()) {
            header('Location: http://radar.gopagoda.com/feeds');
        }

        $data['errors'] = array();
        $data['email'] = '';
        $data['username'] = '';

        $view = new View('pages/signup');
        return $view->render($data);
    } // end signup() method

    /**
     * notFound
     *
     * @access public
     * @return void
     */
    public function notFound()
    {
        include 'views/pages/404.html';
    } // end notFound() method
} // end PagesController class
