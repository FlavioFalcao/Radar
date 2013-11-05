<?php
/**
 * ORM-component: manages database connection using PDO. Modified version of the
 * Singleton design pattern example presented in SitePoint's PHP Master.
 *
 * PHP Version 5
 *
 * @category ORM
 * @package  ORM
 * @author   SitePoint <books@sitepoint.com>
 * @license  Unknown <>
 * @link     http://www.sitepoint.com
 */

/**
 * FeedsDB
 *
 * @uses PDO
 * @category ORM
 * @package  ORM
 * @author   SitePoint <books@sitepoint.com>
 * @license  Unknown <>
 * @link     http://www.sitepoint.com

 */
class FeedsDB extends PDO
{
    private static $_instance = null;

    /**
     * __construct
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct(
            'mysql:host=' . $_SERVER['DB1_HOST'] . ';dbname=' . $_SERVER['DB1_NAME'],
            $_SERVER['DB1_USER'],
            $_SERVER['DB1_PASS']
        );
    } // end __construct() method

    /**
     * getInstance
     * 
     * @static
     * @access public
     * @return Object self::$_instance Instance of FeedsDB class
     */
    public static function getInstance()
    {
        if (!(self::$_instance instanceof FeedsDB)) {
            self::$_instance = new FeedsDB();
        }

        return self::$_instance;
    } // end getInstance() method
}


