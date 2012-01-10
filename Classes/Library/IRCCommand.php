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
         * @param   integer $numberOfArguments The number of arguments, this command will allow.
         * @param   name    $nameOfCommand     The name of the command, used for showing the help. Use -1 to allow unlimited arguments.
         *
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        function __construct( $numberOfArguments = 0 ) {
            $this->numberOfArguments = (integer) $numberOfArguments;
        }

        /**
         * Executes the command.
         *
         * @todo Don't return, use say or poke to show the help instead.
         *
         * @param \Library\IRCBot $IRCBot    The IRC-Bot, that will execute the command.
         * @param array           $arguments The assigned arguments.
         * @return type
         */
        public function executeCommand( \Library\IRCBot $IRCBot, array $arguments ) {
            // If a number of arguments is defined,
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
            throw new Exception( 'You have to overwrite the "command" method and the "executeCommand". Call the parent "executeCommand" and execute your custom "command".' );
        }

    }
?>
