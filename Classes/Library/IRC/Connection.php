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
     * @subpackage Interface
     *
     * @encoding UTF-8
     * @created 11.01.2012
     *
     * @author Daniel Siepmann <coding.layne@me.com>
     */

    namespace Library\IRC;

    /**
     * Interface for irc connection.
     * Defines how to connect and communicate with the irc server.
     *
     * @package IRCBot
     * @subpackage Interface
     *
     * @author Daniel Siepmann <coding.layne@me.com>
     */
    interface Connection {

        /**
         * Establishs the connection to the server.
         */
        public function connect();

        /**
         * Disconnects from the server.
         *
         * @return boolean True if the connection was closed. False otherwise.
         */
        public function disconnect();

        /**
         * Interaction with the server.
         * For example, send commands or some other data to the server.
         *
         * @return boolean FALSE on error.
         */
        public function sendData( $data );

        /**
         * Returns data from the server.
         *
         * @return string|boolean The data as string, or false if no data is available or an error occured.
         */
        public function getData();

        /**
         * Check wether the connection exists.
         *
         * @return boolean True if the connection exists. False otherwise.
         */
        public function isConnected();

    }
?>
