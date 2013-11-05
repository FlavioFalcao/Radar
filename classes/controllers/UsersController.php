<?php
/**
 * Class for processing user authentication and registration
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
 * UsersController
 *
 * @category Controllers
 * @package  Controllers
 * @author   Brad Melanson <bradmelanson@icloud.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/bradJM
 */
class UsersController
{
    /**
     * signin
     *
     * Validate a user's credentials and sign them in
     *
     * @param Object $request Request object containing HTTP request parameters
     *
     * @access public
     * @return View $view Index page for feeds section of site
     */
    public function signin($request)
    {
        $username = $request->parameters['username'];
        $password = (string)$request->parameters['password'];

        if (User::login($username, $password)) {
            header('Location: http://radar.gopagoda.com/feeds');
        } else {
            $data['username'] = $username;
            $data['errors'][] = 'Sorry, your username or password was incorrect';

            $view = new View('pages/signin');
            $view->render($data);
        }
    } // end signin() method

    /**
     * signup
     *
     * Validate a new user's information and register them for the site
     *
     * @param Object $request Request object containing HTTP request parameters
     *
     * @access public
     * @return View $view Index page for feeds section of site
     */
    public function signup($request)
    {
        $email = $request->parameters['email'];
        $username = $request->parameters['username'];
        $password = (string)$request->parameters['password'];
        $confirm_password = (string)$request->parameters['confirm_password'];

        if (preg_match('/^.+@.+$/', $email)
            && preg_match('/^[a-zA-Z0-9\-_]{3,}$/', $username)
            && (strlen($password) > 6)
            && $password === $confirm_password
        ) {
            $user = new User(null, $username, $email);

            $user->save($password);
            User::login($username, $password);
            header('Location: http://radar.gopagoda.com/feeds');
        } else {
            $data['email'] = $email;
            $data['username'] = $username;
            $data['errors'][] = 'Sorry, some of your information was invalid';

            $view = new View('pages/signup');
            $view->render($data);
        }
    } // end signup() method

    /**
     * signup
     *
     * Log the current user out
     *
     * @access public
     * @return View $view Index page for feeds section of site
     */
    public function signout()
    {
        $_SESSION = array();
        header('Location: http://radar.gopagoda.com');
    } // end signout() method
}

