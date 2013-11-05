<?php
/**
 * Class for displaying and processing Feeds
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
 * FeedsController
 *
 * @category Controllers
 * @package  Controllers
 * @author   Brad Melanson <bradmelanson@icloud.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/bradJM
 */

class FeedsController
{
    /**
     * index
     *
     * @param Object $request Request object containing HTTP request parameters
     *
     * @access public
     * @return View $view Index page for feeds section of site
     */
    public function index($request)
    {
        // check path for a feed id
        $url = explode('/', $request->path);

        if (isset($url[2]) && is_numeric($url[2])) {
            // pass a single feed to view if a feed id was found in path
            $feedId = $url[2];
            if ($feed = Feed::find($feedId)) {
                $data['feed'] = $feed;
                $data['articles'] = $feed->getArticles();

                $view = new View('feeds/show');
                $view->render($data);
            } else {
                // render 404 page if feed could not be found
                include 'views/pages/404.html';
                exit();
            }
        } else {
            // redirect to signin page if no user is currently logged in
            if (!(User::current())) {
                header('Location: http://radar.gopagoda.com/signin');
            }

            // get all feeds for the logged in user and pass them to view
            $user = User::find($_SESSION['user_id']);
            $data['feeds'] = $user->getFeeds();

            $view = new View('feeds/index');
            return $view->render($data);
        }
    } // end index() method

    /**
     * subscribe
     *
     * @param Object $request Request object containing HTTP request parameters
     *
     * @access public
     * @return View $view Index page for feeds section of site
     */
    public function subscribe($request)
    {
        if (!(User::current())) {
            header('Location: http://radar.gopagoda.com/signin');
        } else {
            $user = User::find($_SESSION['user_id']);
        }

        $feed = Feed::findByUrl($request->parameters['url'])
            ?: Feed::parse($request->parameters['url']);

        if ($user->addFeed($feed)) {
            $data['success'] = 'Subscribed to '. $feed->title;
        } else {
            $data['error'] = 'Unable to subscribe to ' . $feed->title;
        }

        $data['feeds'] = $user->getFeeds();

        $view = new View('feeds/index');
        return $view->render($data);
    } // end subscribe() method;

    /**
     * unsubscribe
     *
     * @param Object $request Request object containing HTTP request parameters
     *
     * @access public
     * @return View $view Index page for feeds section of site
     */

    public function unsubscribe($request)
    {
        if (!(User::current())) {
            header('Location: http://radar.gopagoda.com/signin');
        } else {
            $user = User::find($_SESSION['user_id']);
        }

        $feed = Feed::find($request->parameters['feed_id']);

        if ($user->removeFeed($feed)) {
            $data['success'] = 'Unsubscribed from '. $feed->title;
        } else {
            $data['error'] = 'Unable to unsubscribe from ' . $feed->title;
        }

        $data['feeds'] = $user->getFeeds();

        $view = new View('feeds/index');
        return $view->render($data);
    } // end unsubscribe() method
} //end FeedsController class
