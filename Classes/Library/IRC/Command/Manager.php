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
     * @created Jan 29, 2012 4:10:53 AM
     *
     * @filesource
     */

    namespace Library\IRC\Command;

    /**
     * Manages all available commands.
     * The execution of commands, and dependencies.
     *
     * @package IRCBot
     * @subpackage Library
     * @author Daniel Siepmann <coding.layne@me.com>
     */
    class Manager {

        /**
         * Replace this by configuration in version
         * @var string
         */
        protected $directoryOfCommands = 'Classes/Command/';
        protected $availablePackages = array ( );
        protected $activePackages = array ( );
        protected $availableCommands = array ( );
        protected $activeCommands = array ( );

        /**
         * Read the directory recursive and get all available packages (folders) and commands (files).
         * Saves them in the properties and a cache file.
         * If the cache file already exists, use this instad.
         *
         * @return boolean True if the packages and command were get. False otherwise,
         *
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        private function getAvailablePackagesAndCommands() {
            if (!$this->readCache() && !$this->readEntireDirectory()) {
                return false;
            }
            return true;
        }

        private function readEntireDirectory() {

        }

        private function readCache() {

        }

        public function activatePackage( $packageName ) {

        }

        public function activateCommand( $commandName, $packageName ) {

        }

        private function laodPackages() {
            foreach ($this->activePackages as $value) {

            }
        }

        private function loadCommands() {

        }

        public function executeCommand( $commandName, $packageName ) {

        }

        private function checkDependencies( $commandName, $packageName ) {

        }

    }
?>
