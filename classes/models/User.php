<?php
/**
 * ORM component. Manages users table and User models
 *
 * PHP Version 5
 *
 * @category ORM
 * @package  ORM
 * @author   Brad Melanson <bradmelanson@icloud.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/bradJM
 */

/**
 * User
 *
 * @uses Model
 * @category ORM
 * @package  ORM
 * @author   Brad Melanson <bradmelanson@icloud.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/bradJM/
 */
class User
{
    private $_id;
    public $username;
    private $_email;

    /**
     * __construct
     *
     * Optionally set instance variables for User object on instantiation
     *
     * @param Integer $id       id of the User
     * @param String  $username username of the User
     * @param String  $email    email of the User
     *
     * @access public
     * @return void
     */
    public function __construct($id = null, $username = null, $email = null)
    {
        $this->_id = $id;
        $this->username = $username;
        $this->_email = $email;
    }

    /**
     * login
     *
     * @param String $username The username to check against table
     * @param String $password The password to be checked against table
     *
     * @static
     * @access public
     * @return Object $user   Instance of User representing the fetched table row
     */
    public static function login($username, $password)
    {
        if ($username && $password) {
            try {
                $sql = 'SELECT id, password FROM users
                        WHERE (username = :username OR email = :email)
                        AND deleted_at = 0';
                $stmt = LoginsDB::getInstance()->prepare($sql);
                $stmt->execute(
                    array(
                        ':username' => $username,
                        ':email'    => $username
                    )
                );

                if ($row = $stmt->fetch()) {
                    $hashedPassword = $row['password'];

                    if (password_verify($password, $hashedPassword)) {
                        $_SESSION['user_id'] = $row['id'];

                        return true;
                    }
                }
            } catch (PDOException $e) {
                return false;
            }
        }

        return false;
    } // end login() method

    /**
     * current
     *
     * Checks for a logged in user using a $_SESSION variable
     *
     * @static
     * @access public
     * @return bool
     */
    public static function current()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }

        return false;
    } // end current() method

    /**
     * all
     *
     * Fetch all Users from the database
     *
     * @static
     * @access public
     * @return Array $users Array of User objects representing all rows in table
     */
    public static function all()
    {
        $users = array();

        $sql = 'SELECT id, username, email FROM users WHERE deleted_at = 0';
        $result = LoginsDB::getInstance()->query($sql);

        while ($row = $result->fetch()) {
            $user = new User($row['id'], $row['username'], $row['email']);

            $users[] = $user;
        }

        return $users;
    } // end all() method

    /**
     * find
     *
     * Fetch one User by id value
     *
     * @param Integer $id id of table row to fetch
     *
     * @static
     * @access public
     * @return Object $user Instance of User representing the fetched table row
     */
    public static function find($id)
    {
        try {
            $sql = 'SELECT id, username, email FROM users
                    WHERE id = :id AND deleted_at = 0';
            $stmt = LoginsDB::getInstance()->prepare($sql);
            $stmt->execute(array(':id' => $id));

            if ($row = $stmt->fetch()) {
                $user = new User($row['id'], $row['username'], $row['email']);

                return $user;
            }
        } catch (PDOException $e) {
            return false;
        }
    } // end find() method

    /**
     * save
     *
     * Save a new User in the table
     *
     * @param String $password Password for new user, hashed before inserting
     *                         into table
     *
     * @access public
     * @return bool
     */
    public function save($password)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        try {
            $sql = 'INSERT INTO users
                    (id, username, email, password, created_at, deleted_at)
                    VALUES ("", :username, :email, :password, NOW(), 0)';
            $stmt = LoginsDB::getInstance()->prepare($sql);
            $stmt->execute(
                array(
                    ':username' => $this->username,
                    ':email'    => $this->_email,
                    ':password' => $hashedPassword
                )
            );

            return true;
        } catch (PDOException $e) {
            return false;
        }
    } // end save() method

    /**
     * delete
     *
     * Flag an existing User as deleted
     *
     * @access public
     * @return bool
     */
    public function delete()
    {
        try {
            $sql = 'UPDATE users SET deleted_at = NOW() WHERE id = :id';
            $stmt = LoginsDB::getInstance()->prepare($sql);
            $stmt->execute(array(':id' => $this->_id));

            return true;
        } catch (PDOException $e) {
            return false;
        }
    } // end delete() method

    /**
     * addFeed
     *
     * @param mixed $feed Feed to add to user_feeds table
     *
     * @access public
     * @return void
     */
    public function addFeed($feed)
    {
        try {
            $sql = 'INSERT INTO user_feeds (user_id, feed_id, created_at)
                    VALUES (:user_id, :feed_id, NOW())';
            $stmt = FeedsDB::getInstance()->prepare($sql);
            $stmt->execute(
                array(
                    ':user_id' => $this->_id,
                    ':feed_id' => $feed->getId()
                )
            );

            return true;
        } catch (PDOException $e) {
            return false;
        }
    } // end addFeed() method

    /**
     * removeFeed
     *
     * @param mixed $feed Feed to remove from user_feeds table
     *
     * @access public
     * @return void
     */

    public function removeFeed($feed)
    {
        try {
            $sql = 'DELETE FROM user_feeds
                    WHERE user_id = :user_id
                    AND feed_id = :feed_id';
            $stmt = FeedsDB::getInstance()->prepare($sql);
            $stmt->execute(
                array(
                    ':user_id' => $this->_id,
                    ':feed_id' => $feed->getId()
                )
            );

            return true;
        } catch (PDOException $e) {
            return false;
        }
    } // end removeFeed() method

    /**
     * getFeeds
     *
     * Get all Feeds associated with this user
     *
     * @access public
     * @return Array $feeds Array of Feed objects representing all user's Feeds
     */
    public function getFeeds()
    {
        $feeds = array();

        $sql = 'SELECT id, url, title, description
                FROM feeds
                LEFT OUTER JOIN user_feeds
                ON user_feeds.feed_id = feeds.id
                WHERE user_feeds.user_id = :user_id
                AND feeds.deleted_at = 0';
        $stmt = FeedsDB::getInstance()->prepare($sql);
        $stmt->execute(array(':user_id' => $this->_id));

        while ($row = $stmt->fetch()) {
            $feed = new Feed(
                $row['id'], $row['url'], $row['title'], $row['description']
            );

            $feeds[] = $feed;
        }

        return $feeds;
    } // end getFeeds() method
} // end User class


