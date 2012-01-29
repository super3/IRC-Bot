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
     *
     * @encoding UTF-8
     * @created Jan 29, 2012 4:30:02 AM
     *
     * @filesource
     */

    namespace Library\IRC\Command;

    /**
     * A package of commands.
     * A package hold multiple commands.
     * It's just used to organize and group commands.
     *
     * @package IRCBot
     * @subpackage Library
     * @author Daniel Siepmann <coding.layne@me.com>
     */
    class Package {

        private $commands = array ( );


        function __construct( ) {

        }


        /**
         * Returns all commands of the package.
         * @return array
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        public function getCommands() {
            return $this->commands;
        }

    }
?>
