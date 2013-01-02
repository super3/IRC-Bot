<?php
    /**
     * LICENSE: This source file is subject to Creative Commons Attribution
     * 3.0 License that is available through the world-wide-web at the following URI:
     * http://creativecommons.org/licenses/by/3.0/.  Basically you are free to adapt
     * and use this script commercially/non-commercially. My only requirement is that
     * you keep this header as an attribution to my work. Enjoy!
     *
     * @license http://creativecommons.org/licenses/by/3.0/
     *
     * @package IRCBot
     * @subpackage Library
     * @author Daniel Siepmann <coding.layne@me.com>
     *
     * @encoding UTF-8
     * @created 30.12.2011 20:29:55
     *
     * @filesource
     */

    namespace Library\IRC\Command;

    /**
     * An IRC command.
     *
     * @package IRCBot
     * @subpackage Library
     * @author Daniel Siepmann <daniel.siepmann@me.com>
     */
    abstract class Base {

        /**
         * Reference to the IRC Connection.
         * @var \Library\IRC\Connection
         */
        protected $connection = null;

        /**
         * Reference to the IRC Bot
         * @var \Lirary\IRC\Bot
         */
        protected $bot = null;

        /**
         * Contains all given arguments.
         * @var array
         */
        protected $arguments = array ( );

        /**
         * Contains channel or user name
         *
         * @var string
         */
        protected $source = null;

        /**
         * Original request from server
         *
         * @var string
         */
        private $data;

        /**
         * The number of arguments the command needs.
         *
         * You have to define this in the command.
         *
         * @var integer
         */
        protected $numberOfArguments = 0;

        /**
         * The help string, shown to the user if he calls the command with wrong parameters.
         *
         * You have to define this in the command.
         *
         * @var string
         */
        protected $help = '';

        /**
         * Executes the command.
         *
         * @param array           $arguments The assigned arguments.
         * @param string          $source    Originating request
         * @param string          $data      Original data from server
         */
        public function executeCommand( array $arguments, $source, $data ) {
            // Set source
            $this->source = $source;

            // Set data
            $this->data = $data;

            // If a number of arguments is incorrect then run the command, if
            // not then show the relevant help text.
            if ($this->numberOfArguments != -1 && count( $arguments ) != $this->numberOfArguments) {
                // Show help text.
                $this->say(' Incorrect Arguments. Usage: ' . $this->getHelp());
            }
            else {
                // Set Arguments
                $this->arguments = $arguments;

                // Execute the command.
                $this->command();
            }
        }

        /**
         * Sends PRIVMSG to source with $msg
         *
         * @param string $msg
         */
       protected function say($msg) {
            $this->connection->sendData(
                    'PRIVMSG ' . $this->source . ' :' . $msg
            );
        }

        private function getHelp() {
           return $this->help;
        }

        /**
         * Overwrite this method for your needs.
         * This method is called if the command get's executed.
         */
        public function command() {
            echo 'fail';
            flush();
            throw new Exception( 'You have to overwrite the "command" method and the "executeCommand". Call the parent "executeCommand" and execute your custom "command".' );
        }

        /**
         * Set's the IRC Connection, so we can use it to send data to the server.
         * @param \Library\IRC\Connection $ircConnection
         */
        public function setIRCConnection( \Library\IRC\Connection $ircConnection ) {
            $this->connection = $ircConnection;
        }

        /**
         * Set's the IRC Bot, so we can use it to send data to the server.
         *
         * @param \Library\IRCBot $ircBot
         */
        public function setIRCBot( \Library\IRC\Bot $ircBot ) {
            $this->bot = $ircBot;
        }

        /**
         * Returns requesting user IP
         *
         * @return string
         */
        protected function getUserIp() {
            // catches from @ to first space
            if (preg_match('/@([a-z0-9.-]*) /i', $this->data, $match) === 1) {
                $hostname = $match[1];

                $ip = gethostbyname($hostname);

                // did we really get an IP
                if (preg_match( '/(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})/', $ip ) === 1) {
                    return $ip;
                }
            }

            return null;
        }

        /**
         * Fetches data from $uri
         *
         * @param string $uri
         * @return string
         */
        protected function fetch($uri) {

            $this->bot->log("Fetching from URI: " . $uri);

            // create curl resource
            $ch = curl_init();

            // set url
            curl_setopt($ch, CURLOPT_URL, $uri);

            //return the transfer as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);

            // $output contains the output string
            $output = curl_exec($ch);

            // close curl resource to free up system resources
            curl_close($ch);

            $this->bot->log("Data fetched: " . $output);

            return $output;
        }
    }
?>
