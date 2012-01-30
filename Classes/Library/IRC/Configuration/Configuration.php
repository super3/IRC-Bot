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
     * @subpackage Configuration
     * @author Daniel Siepmann <coding.layne@me.com>
     *
     * @encoding UTF-8
     * @created Jan 29, 2012 5:58:41 AM
     *
     * @filesource
     */

    namespace Library\IRC\Configuration;

    /**
     * Description of Configuration
     *
     * @package IRCBot
     * @subpackage Configuration
     * @author Daniel Siepmann <coding.layne@me.com>
     */
    class Configuration {

        /**
         * The file that holds the configuration.
         * @var string
         */
        protected $configurationFile = '';

        /**
         * The name of the configuration.
         * @var string
         */
        protected $configurationName = '';

        /**
         * A short description of the configuration.
         * @var string
         */
        protected $configurationDescription = '';

        /**
         * The name/host of the IRC Server.
         * @var string
         */
        protected $server = '';

        /**
         * The port of the IRC Server.
         * @var integer
         */
        protected $port = 0;

        /**
         * The number of maximum reconnects,
         * before the bot stops trying reconnecting to the server.
         * @var integer
         */
        protected $maxReconnects = 0;

        /**
         * The name of the bot visible for IRC users.
         * @var string
         */
        protected $botName = '';

        /**
         * The nick of the bot visible for IRC users.
         * @var string
         */
        protected $botNick = '';

        /**
         * A list of all channels the bot will connect to,
         * after connecting to the server.
         * @var array
         */
        protected $channels = array ( );

        /**
         * All commands the bot should know.
         * @var array
         */
        protected $commands = array ( );

        /**
         * All packages of commands the bot should know.
         * @var array
         */
        protected $packages = array ( );

        /**
         * The absolute path to the file the bot should write the logs to.
         * @var string
         */
        protected $logFile = '';

        /**
         * Enables or disables the logging mechanism.
         * @var boolean
         */
        protected $enableLogging = false;

        /**
         * Enables or disabled the error reporting.
         * False if errors should be ignored where possible.
         * @var boolean
         */
        protected $errorReporting = true;

        /**
         * Defines wether to show or hide errors.
         * True if you want to see errors.
         * @var boolean
         */
        protected $errorDisplay = true;

        /**
         * Defines wether to log or not errors.
         * True if you want to log errors via logging. Remeber to enable logging.
         * @var boolean
         */
        protected $errorLogging = true;

        /**
         * Defines the environment.
         * @var boolean
         */
        protected $envMode;

        function __construct( \Bootstrap $bootstrap ) {
            $this->envMode = $bootstrap->getEnv();
        }

        public function parseJSONFile( $configurationFile ) {
            $this->configurationFile = $configurationFile;
            unset( $configurationFile );
            $jsonError = '';
            $configurationFileContent = '';
            $configurationAsJson = '';

            if (!is_readable( $this->configurationFile )) {
                throw new \Library\Exception( "Configuration file does not exist, or is not readable.\rFile was: " . $this->configurationFile, 1327883282 );
            }

            // Get file content.
            $configurationFileContent = file_get_contents( $this->configurationFile );
            if ($configurationFileContent === false) {
                throw new \Library\Exception( "Could not read the content of configuration file.\rFile was: " . $this->configurationFile, 1327884415 );
            }

            // Decode json content.
            $configurationAsJson = json_decode( $configurationFileContent );
            if ($configurationAsJson === NULL) {
                switch (json_last_error()) {
                    case JSON_ERROR_NONE:
                        break;
                    case JSON_ERROR_DEPTH:
                        $jsonError = 'Maximum stack depth exceeded';
                        break;
                    case JSON_ERROR_STATE_MISMATCH:
                        $jsonError = 'Underflow or the modes mismatch';
                        break;
                    case JSON_ERROR_CTRL_CHAR:
                        $jsonError = 'Unexpected control character found';
                        break;
                    case JSON_ERROR_SYNTAX:
                        $jsonError = 'Syntax error, malformed JSON';
                        break;
                    case JSON_ERROR_UTF8:
                        $jsonError = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                        break;
                    default:
                        $jsonError = 'Unknown error';
                        break;
                }
                throw new \Library\Exception( "Could not parse the content of configuration file as JSON.\rError was: " . $jsonError . "\rFile was: " . $this->configurationFile, 1327884415 );
            }
            // No error, parse config.
            $this->parseJSONConfiguration( $configurationAsJson );
        }

        private function parseJSONConfiguration( \stdClass $configuration ) {
            // parsing ERROR ...
            // Get configuration name.
            if (!isset( $configuration->errors ) || !is_a( $configuration->errors, 'stdClass' )) {
                throw new \Library\Exception( "Parsing Error. No property 'errors' found, or property 'errors' is not type of object.\rFile was: " . $this->configurationFile, 1327885185 );
            }
            if (!isset( $configuration->errors->reporting ) || !is_bool( $configuration->errors->reporting )) {
                throw new \Library\Exception( "Parsing Error. No property 'errors.reporting' found, or property 'errors.reporting' is not type of boolean.\rFile was: " . $this->configurationFile, 1327885185 );
            }
            $this->errorReporting = $configuration->errors->reporting;
            if (!isset( $configuration->errors->display ) || !is_bool( $configuration->errors->display )) {
                throw new \Library\Exception( "Parsing Error. No property 'errors.display' found, or property 'errors.display' is not type of boolean.\rFile was: " . $this->configurationFile, 1327885185 );
            }
            $this->errorDisplay = $configuration->errors->display;
            if (!isset( $configuration->errors->logging ) || !is_bool( $configuration->errors->logging )) {
                throw new \Library\Exception( "Parsing Error. No property 'errors.logging' found, or property 'errors.logging' is not type of boolean.\rFile was: " . $this->configurationFile, 1327885185 );
            }
            $this->errorLogging = $configuration->errors->logging;


            // parse CONFIGURATIO ...
            // Get configuration name.
            if (!isset( $configuration->name ) || !is_string( $configuration->name )) {
                throw new \Library\Exception( "Parsing Error. No property 'name' found, or property 'name' is not type of string.\rFile was: " . $this->configurationFile, 1327885185 );
            }
            $this->configurationName = $configuration->name;

            // Get configuration description.
            if (!isset( $configuration->description ) || !is_string( $configuration->description )) {
                throw new \Library\Exception( "Parsing Error. No property 'description' found, or property 'name' is not type of string.\rFile was: " . $this->configurationFile, 1327885185 );
            }
            $this->configurationDescription = $configuration->description;
        }

    }
?>
