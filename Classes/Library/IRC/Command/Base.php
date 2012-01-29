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
         * @param \Library\IRCBot $IRCBot    The IRC-Bot, that will execute the command.
         * @param array           $arguments The assigned arguments.
         * @return type
         */
        public function executeCommand( array $arguments, $source ) {
            // If a number of arguments is incorrect then run the command, if
            // not then show the relevant help text.
            if ($this->numberOfArguments != -1 && count( $arguments ) != $this->numberOfArguments) {
                // Show help text.
                $this->connection->sendData( 'PRIVMSG '. $source. ' :Incorrect Arguments. Usage: ' .
                $this->getHelp());
            }
            else {
                // Set Arguments
                $this->arguments = $arguments;
                // Execute the command.
                $this->command();
            }
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
         * @param \Library\IRCBot $ircBot
         */
        public function setIRCBot( \Library\IRC\Bot $ircBot ) {
            $this->bot = $ircBot;
        }

    }
?>
