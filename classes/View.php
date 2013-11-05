<?php
/**
 * Class for rendering templates
 *
 * PHP Version 5
 *
 * @category Helpers
 * @package  Helpers
 * @author   Brad Melanson <bradmelanson@icloud.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/bradJM
 */

/**
 * View
 *
 * @category Helpers
 * @package  Helpers
 * @author   Brad Melanson <bradmelanson@icloud.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/bradJM
 */
class View
{
    private $_header;
    private $_footer;
    private $_template;
    private $_data;

    /**
     * __construct
     *
     * @param String $template The template to be rendered
     * @param String $header   (Optional) header to be rendered instead of
     *                         default
     * @param String $footer   (Optional) footer to be rendered instead of
     *                         default
     *
     * @access public
     * @return void
     */
    public function __construct($template, $header = null, $footer = null)
    {
        $this->_header = $header ?: 'views/partials/header.html.php';
        $this->_footer = $footer ?: 'views/partials/footer.html.php';
        $this->_template = 'views/' . $template . '.html.php';
    }

    /**
     * render
     *
     * @param mixed $data (Optional) Data to be included in template
     *
     * @access public
     * @return void
     */
    public function render($data = null)
    {
        $this->_data = $data ?: array();

        include $this->_header;
        include $this->_template;
        include $this->_footer;
    }
}
