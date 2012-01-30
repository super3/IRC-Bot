<?php
    /**
     * This file contains the class: "Bootstrap".
     *
     * @package
     * @subpackage
     * @author Daniel Siepmann <coding.layne@me.com>
     *
     * @encoding UTF-8
     * @created Jan 29, 2012 7:08:38 AM
     *
     * @filesource
     */
    set_time_limit( 0 );
    ini_set( 'display_errors', 'on' );

    /**
     * Description of Bootstrap
     *
     * @package
     * @subpackage
     * @author Daniel Siepmann <coding.layne@me.com>
     */
    class Bootstrap {

        const CLI = 1;
        const BROWSER = 2;

        /**
         * The current version.
         * @var string
         */
        const version = '0.2.0-dev';
        /**
         * All authors.
         * @var array
         */
        const authors = 'Daniel Siepmann and Shawn Wilkinson';
        const url_to_exception = 'https://github.com/pogosheep/IRC-Bot/wiki/Exceptions';

        /**
         * Environment.
         * @var integer
         */
        private $env = self::CLI;

        function __construct() {
            if (!isset( $GLOBALS['argc'] )) {
                $this->env = self::BROWSER;
            }
//            if (stripos( self::version, 'dev' ) === false) {
            $this->initExceptionHandler();
//            }
            $this->initAutoloader();
            $this->initConfiguration();
//            $this->initBot();
        }

        /**
         * Initializes the exception handler.
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        protected function initExceptionHandler() {
            require 'Classes/ExceptionHandler.php';
            if ($this->env === self::BROWSER) {
                set_exception_handler( 'ExceptionHandler::handleBrowserException' );
            }
            else {
                set_exception_handler( 'ExceptionHandler::handleCLIException' );
            }
        }

        /**
         * Initializes the autoloader.
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        protected function initAutoloader() {
            require 'Classes/Autoloader.php';
            spl_autoload_register( 'Autoloader::load' );
        }

        protected function initConfiguration() {
            $configurationFile = '';

            // Called from CLI, get configuration from arguments.
            if ($this->env === self::CLI) {
                if (!isset( $GLOBALS['argv'][1] )) {
                    throw new Library\Exception( 'No configuration file. Please pass the configuration file.', 1327882348 );
                }
                else {
                    $configurationFile = 'Configuration/' . $GLOBALS['argv'][1] . '.json';
                }
            }
            // Called from Browser, get configuration from ... .
            else {

            }

            $configuration = new \Library\IRC\Configuration\Configuration( $this );
            $configuration->parseJSONFile( $configurationFile );
        }

        /**
         * Initializes the bot.
         * @throws Library\Exception
         */
        protected function initBot() {
            // Create the bot.
            $bot = new Library\IRC\Bot( $configuration );
            // Connect to the server.
            $bot->connectToServer();
        }

        /**
         * Returns the version number.
         * @return string
         */
        public function getVersion() {
            return $this->version;
        }

        /**
         * Returns an array with all authors.
         * @return array
         */
        public function getAuthors() {
            return $this->authors;
        }

        /**
         * Returns the current environment.
         * @return integer
         */
        public function getEnv() {
            return $this->env;
        }

    }
    $bootstrap = new Bootstrap();
?>
