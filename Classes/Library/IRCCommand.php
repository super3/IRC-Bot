<?php
    /**
     * LICENSE: This source file is subject to Creative Commons Attribution
     * 3.0 License that is available through the world-wide-web at the following URI:
     * http://creativecommons.org/licenses/by/3.0/.  Basically you are free to adapt
     * and use this script commercially/non-commercially. My only requirement is that
     * you keep this header as an attribution to my work. Enjoy!
     *
     * @license http://creativecommons.org/licenses/by/3.0/
     * @link    https://bitbucket.org/pogosheep/irc-bot
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

    namespace Library;

    /**
     * An IRC command.
     *
     * @package IRCBot
     * @subpackage Library
     * @author Daniel Siepmann <daniel.siepmann@me.com>
     */
    abstract class IRCCommand {

        /**
         * Reference to the IRCBot.
         * @var \Library\IRCBot
         */
        protected $IRCBot = null;

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
        private $help = '';

        /**
         * __construct
         *
         * @param integer $numberOfArguments
         * @param name $nameOfCommand
         *
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        function __construct( $numberOfArguments = 0 ) {
            $this->numberOfArguments = (integer) $numberOfArguments;
        }

        public function executeCommand( \Library\IRCBot $IRCBot, array $arguments ) {
            if ($this->numberOfArguments !== -1 && count( $arguments ) !== $this->numberOfArguments) {
                return $this->getHelp();
            }

            $this->IRCBot = $IRCBot;
            $this->arguments = $arguments;

            // Execute the command.
            $this->command();
        }

        private function getHelp() {

        }

        /**
         * Overwrite this method for your needs.
         * This method is calles if the command get's executed.
         */
        public function command() {
            echo 'fail';
            flush();
            exit;
            throw new Exception( 'You have to overwrite the "command" method and the "executeCommand". Call the parent "executeCommand" and execute your custom "command".' );
        }

    }
?>
