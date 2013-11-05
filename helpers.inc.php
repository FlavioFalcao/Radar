<?php
/**
 * Miscellaneous helper functions
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
 * Shortcut for escaping text with htmlspecialchars
 *
 * @param String $text Text to be escaped
 *
 * @return String The escaped text
 */
function html($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

