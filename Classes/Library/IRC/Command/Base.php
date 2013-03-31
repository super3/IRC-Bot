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
    abstract class Base extends \Library\IRC\Base {

        /**
         * Contains all given arguments.
         * @var array
         */
        protected $arguments = array ( );
        
        /**
         * Contains the nick/host/username of the user who issued the command.
         * @var string
         */
        protected $privSource = null;

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
        public function executeCommand( array $arguments, $privSource, $source, $data ) {
            // Set priv source
            $this->privSource = $privSource;
            
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
    }
?>
