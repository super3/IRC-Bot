<?php
    /**
     * This file contains the class: "Autoloader".
     *
     * LICENSE: This source file is subject to Creative Commons Attribution
     * 3.0 License that is available through the world-wide-web at the following URI:
     * http://creativecommons.org/licenses/by/3.0/.  Basically you are free to adapt
     * and use this script commercially/non-commercially. My only requirement is that
     * you keep this header as an attribution to my work. Enjoy!
     *
     * @license http://creativecommons.org/licenses/by/3.0/
     *
     * @package IRCBot
     * @author Daniel Siepmann <coding.layne@me.com>
     *
     * @encoding UTF-8
     * @created 30.12.2011 20:42:20
     *
     * @filesource
     */

    /**
     * A minimum autoloader
     *
     * @package IRCBot
     * @author Daniel Siepmann <coding.layne@me.com>
     */
    class Autoloader {

        /**
         * Includes the PHP-File for the specified class.
         * @param string $class The classname.
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        public static function load( $class ) {
            $filename = __DIR__ . '/' . str_replace( '\\', '/', $class ) . '.php';
            if (file_exists($filename)) {
                return require $filename;
            }
            throw new Exception('File: "' . $filename . '" not found.');
        }

    }
?>
