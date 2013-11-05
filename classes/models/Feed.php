<?php
/**
 * ORM component. Manages feeds table and Feed models
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
 * Feed
 *
 * @uses Model
 * @category ORM
 * @package  ORM
 * @author   Brad Melanson <bradmelanson@icloud.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/bradJM/
 */
class Feed
{
    private $_id;
    public $url;
    public $title;
    public $description;

    /**
     * __construct
     *
     * Optionally set instance variables for Feed object on instantiation
     *
     * @param Integer $id          id of the Feed
     * @param String  $url         url of the Feed
     * @param String  $title       title of the Feed
     * @param String  $description description of the Feed
     *
     * @access public
     * @return void
     */
    public function __construct(
        $id = null, $url = null, $title = null, $description = null
    ) {
        $this->_id = $id;
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * all
     *
     * Fetch all Feeds from database
     *
     * @static
     * @access public
     * @return Array $feeds Array of Feed objects representing all rows in table
     */
    public static function all()
    {
        $feeds = array();

        $sql = 'SELECT * FROM feeds WHERE deleted_at = 0';
        $result = FeedsDB::getInstance()->query($sql);

        while ($row = $result->fetch()) {
            $feed = new Feed(
                $row['id'], $row['url'], $row['title'], $row['description']
            );

            $feeds[] = $feed;
        }

        return $feeds;
    } // end all() method

    /**
     * find
     *
     * Fetch one Feed by id value
     *
     * @param Integer $id id of table row to fetch
     *
     * @static
     * @access public
     * @return Object $feed Instance of Feed representing the fetched table row
     */
    public static function find($id)
    {
        try {
            $sql = 'SELECT * FROM feeds WHERE id = :id AND deleted_at = 0';
            $stmt = FeedsDB::getInstance()->prepare($sql);
            $stmt->execute(array(':id' => $id));

            if ($row = $stmt->fetch()) {
                $feed = new Feed(
                    $row['id'], $row['url'], $row['title'], $row['description']
                );

                return $feed;
            }
        } catch (PDOException $e) {
            return false;
        }
    } // end find() method

    /**
     * findByUrl
     *
     * Fetch one Feed by any column value
     *
     * @param mixed $url The url to search the table for
     *
     * @static
     * @access public
     * @return Object $feed Instance of Feed representing the fetched table row
     */
    public static function findByUrl($url)
    {
        try {
            $sql = 'SELECT * FROM feeds
                    WHERE url = :url AND deleted_at = 0';
            $stmt = FeedsDB::getInstance()->prepare($sql);
            $stmt->execute(array(':url'  => $url));

            if ($row = $stmt->fetch()) {
                $feed = new Feed(
                    $row['id'], $row['url'], $row['title'], $row['description']
                );

                return $feed;
            }
        } catch (PDOException $e) {
            return false;
        }
    } // end findBy() method

    /**
     * recent
     *
     * Fetch recently-subscribed Feeds
     *
     * @static
     * @access public
     * @return Array $feeds Array of Feed objects
     */
    public static function recent()
    {
        $feeds = array();

        try {
            if (User::current()) {
                $sql = 'SELECT id, url, title, description
                        FROM feeds f LEFT OUTER JOIN user_feeds uf
                        ON f.id = uf.feed_id
                        WHERE uf.user_id != :user_id
                        AND f.deleted_at = 0
                        ORDER BY f.created_at DESC LIMIT 10';
                $stmt = FeedsDB::getInstance()->prepare($sql);
                $stmt->execute(array(':user_id' => $_SESSION['user_id']));
            } else {
                $sql = 'SELECT * FROM feeds WHERE deleted_at = 0
                    ORDER BY created_at DESC LIMIT 10';
                $stmt = FeedsDB::getInstance()->query($sql);
            }

            while ($row = $stmt->fetch()) {
                $feed = new Feed(
                    $row['id'], $row['url'], $row['title'], $row['description']
                );

                $feeds[] = $feed;
            }

            return $feeds;
        } catch (PDOException $e) {
            return false;
        }
    } // end recent() method

    /**
     * parse
     *
     * Parse a RSS feed and create a new Feed object from the information
     *
     * @param String $url The URL of the RSS feed
     *
     * @static
     * @access public
     * @return Object $feed The Feed object created from the parsed 
     *                      information
     */
    public static function parse($url)
    {
        $rss = simplexml_load_file($url);
        $channel = $rss->channel;
        $newFeed = new Feed(null, $url, $channel->title, $channel->description);
        $newFeed->save();

        $id = FeedsDB::getInstance()->lastInsertId();
        $feed = Feed::find($id);

        return $feed;
    } // end parse() method

    /**
     * getArticles
     *
     * Get all articles from a Feed's URL
     *
     * @access public
     * @return Array $articles All articles associated with Feed
     */
    public function getArticles()
    {
        $articles = array();

        if ($rss = simplexml_load_file($this->url)) {
            foreach ($rss->channel->item as $item) {
                $articles[] = array(
                    'title'       => $item->title,
                    'link'        => $item->link ?: $item->guid,
                    'description' => $item->description
                );
            }
        }

        return $articles;
    } // end getArticles() method

    /**
     * save
     *
     * Save a new Feed in the table
     *
     * @access public
     * @return bool
     */
    public function save()
    {
        try {
            $sql = 'INSERT INTO feeds
                    (id, url, title, description, created_at, deleted_at)
                    VALUES ("", :url, :title, :description, NOW(), 0)';
            $stmt = FeedsDB::getInstance()->prepare($sql);
            $stmt->execute(
                array(
                    ':url'         => $this->url,
                    ':title'       => $this->title,
                    ':description' => $this->description
                )
            );

            return true;
        } catch (PDOException $e) {
            return false;
        }
    } // end save() method

    /**
     * update
     *
     * Update an existing Feed in the table
     *
     * @access public
     * @return bool
     */
    public function update()
    {
        try {
            $sql = 'UPDATE feeds SET url = :url,
                    title = :title, description = :description
                    WHERE id = :id AND deleted_at = 0';
            $stmt = FeedsDB::getInstance()->prepare($sql);
            $stmt->execute(
                array(
                    ':url'         => $this->url,
                    ':title'       => $this->title,
                    ':description' => $this->description,
                    ':id'          => $this->_id
                )
            );
        } catch (PDOException $e) {
            return false;
        }
    } // end update() method

    /**
     * delete
     *
     * Flag an existing Feed as deleted
     *
     * @access public
     * @return bool
     */
    public function delete()
    {
        try {
            $sql = 'UPDATE feeds SET deleted_at = NOW() WHERE id = :id';
            $stmt = FeedsDB::getInstance()->prepare($sql);
            $stmt->execute(array(':id' => $this->_id));

            return true;
        } catch (PDOException $e) {
            return false;
        }
    } // end delete() method

    /**
     * getId
     *
     * @access public
     * @return Integer $id The id of the current Feed instance
     */
    public function getId()
    {
        return $this->_id;
    } // end getId() method
} // end Feed class

