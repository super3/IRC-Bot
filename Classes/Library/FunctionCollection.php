<?php
    /**
     * IRC Bot
     *
     * LICENSE: This source file is subject to Creative Commons Attribution
     * 3.0 License that is available through the world-wide-web at the following URI:
     * http://creativecommons.org/licenses/by/3.0/.  Basically you are free to adapt
     * and use this script commercially/non-commercially. My only requirement is that
     * you keep this header as an attribution to my work. Enjoy!
     *
     * @license    http://creativecommons.org/licenses/by/3.0/
     *
     * @package IRCBot
     * @subpackage Library
     * @author Daniel Siepmann <coding.layne@me.com>
     *
     * @encoding UTF-8
     * @created 30.12.2011 21:45:07
     *
     * @filesource
     */

    namespace Library;

    /**
     * Description of FunctionCollection
     *
     * @package IRCBot
     * @subpackage Library
     * @author Daniel Siepmann <Daniel.Siepmann@wfp2.com>
     */
    class FunctionCollection {

        /**
         * Removes line breaks from a string.
         *
         * @param string $string The string with line breaks.
         * @return string
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        public static function removeLineBreaks( $string ) {
            return str_replace( array ( chr( 10 ), chr( 13 ) ), '', $string );
        }

    }
?>
