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
     * @author     Super3boy <admin@wildphp.com>
     * @copyright  2010, The Nystic Network
     * @license    http://creativecommons.org/licenses/by/3.0/
     * @link       http://wildphp.com (Visit for updated versions and more free scripts!)
     * @link       https://bitbucket.org/pogosheep/irc-bot
     *
     *
     * @package IRCBot
     * @subpackage Library
     *
     * @encoding UTF-8
     * @created 30.12.2011 20:29:55
     *
     * @author Daniel Siepmann <coding.layne@me.com>
     */

    namespace Library;

    /**
     * A simple IRC Bot with basic features.
     *
     * @package IRCBot
     * @subpackage Library
     *
     * @author Super3boy <admin@wildphp.com>
     * @author Daniel Siepmann <coding.layne@me.com>
     */
    class IRCBot {


        // Configuration


        /**
         * The server you want to connect to.
         * @var string
         */
        public $server = '';
        /**
         * The port of the server you want to connect to.
         * @var integer
         */
        public $port = 0;
        /**
         * A list of all channels the bot should connect to.
         * @var array
         */
        public $channel = array( );
        /**
         * The name of the bot.
         * @var string
         */
        public $name = '';
        /**
         * The nick of the bot.
         * @var string
         */
        public $nick = '';
        /**
         * The number of reconnects before the bot stops running.
         * @var integer
         */
        public $maxReconnects = 0;

        /**
         * Complete file path to the log file.
         * Configure the path, the filename is generated and added.
         * @var string
         */
        public $logFile = 'Logs/';


        // Private properties


        /**
         * The TCP/IP connection.
         * @var type
         */
        private $socket;

        /**
         * The nick of the bot.
         * @var string
         */
        private $nickToUse = '';

        /**
         * Defines the prefix for all commands interacting with the bot.
         * @var String
         */
        private $commandPrefix = '!';

        /**
         * All of the messages both server and client
         * @var array
         */
        private $ex = array ( );

        /**
         * The nick counter, used to generate a available nick.
         * @var integer
         */
        private $nickCounter = 0;

        /**
         * Contains the number of reconnects.
         * @var integer
         */
        private $numberOfReconnects = 0;

        /**
         * All available commands.
         * Commands are type of IRCCommand
         * @var array
         */
        private $commands = array ( );

        /**
         * Holds the reference to the file.
         * @var type
         */
        private $logFileHandler = null;


        /**
         * Construct item, opens the server connection, logs the bot in
         * @param array $config
         *
         * @author Super3boy <admin@wildphp.com>
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        public function __construct() {
            $this->logFile .= date( 'd-m-Y' ) . '.log';
            $this->logFileHandler = fopen( $this->logFile, 'w+' );
        }

        /**
         *
         * @param string  $server The server. Eg: irc.quakenet.org
         * @param integer $port   The port. Eg: 6667
         */
        public function connectToServer() {
            if (empty( $this->nickToUse )) {
                $this->nickToUse = $this->nick;
            }
            if (is_resource( $this->socket )) {
                fclose( $this->socket );
            }
            $this->log( 'The following commands are known by the bot: "' . implode( ',', array_keys( $this->commands ) ) . '".', 'INFO' );
            $this->log( 'Connecting to server "' . $this->server . '" on port "' . $this->port . '".', 'INFO' );
            $this->socket = fsockopen( $this->server, $this->port );
            $this->sendDataToServer( 'USER ' . $this->nickToUse . ' Layne-Obserdia.de ' . $this->nickToUse . ' :' . $this->name );
            $this->sendDataToServer( 'NICK ' . $this->nickToUse );
            $this->main();
        }

        /**
         * This is the workhorse function, grabs the data from the server and displays on the browser
         * @param type $config
         *
         * @author Super3boy <admin@wildphp.com>
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        private function main() {
            do {
                $command = '';
                $arguments = array ( );
                $data = fgets( $this->socket, 256 );

                // Check for some special situations and react:

                if (stripos( $data, 'Nickname is already in use.' ) !== false) {
                    $this->nickToUse = $this->nick . (++$this->nickCounter);
                    $this->sendDataToServer( 'NICK ' . $this->nickToUse );
                }

                if (stripos( $data, 'Welcome' ) !== false) {
                    $this->join_channel( $this->channel );
                }

                if (stripos( $data, 'Registration Timeout' ) !== false ||
                    stripos( $data, 'Erroneous Nickname' ) !== false ||
                    stripos( $data, 'Closing Link' ) !== false) {
                    if ($this->numberOfReconnects >= (int) $this->maxReconnects) {
                        $this->log( 'Closing Link after "' . $this->numberOfReconnects . '" reconnects.', 'EXIT' );
                        exit;
                    }

                    $this->log( $data, 'CONNECTION LOST' );
                    // Wait before reconnect:
                    sleep( 60 * 1 );
                    ++$this->numberOfReconnects;
                    $this->connectToServer( $this->server, $this->port );
                    return;
                }

                // Get the response from irc:
                $args = explode( ' ', $data );
                $this->log( $data );


                // Play ping pong with server:
                if ($args[0] == 'PING') {
                    $this->sendDataToServer( 'PONG ' . $args[1] ); //Plays ping-pong with the server to stay connected.
                }

                // Nothing from the server, step over.
                if ($args[0] == 'PING' || !isset( $args[3] )) {
                    continue;
                }

                // Explode get the command.
                $command = substr( trim( FunctionCollection::removeLineBreaks( $args[3] ) ), 1 );
                $arguments = array_slice( $args, 4 );
                unset( $args );
                if (stripos( $command, $this->commandPrefix ) === 0) {
                    $command = ucfirst( substr( $command, 1 ) );

                    // Command does not exist:
                    if (!array_key_exists( $command, $this->commands )) {
                        $this->log( 'The following, not existing, command was called: "' . $command . '".', 'MISSING' );
                        $this->log( 'The following commands are known by the bot: "' . implode( ',', array_keys( $this->commands ) ) . '".', 'MISSING' );
                        continue;
                    }

                    // Execute command:
                    $command = $this->commands[$command];
                    /* @var $command IRCCommand */
                    $command->executeCommand( $this, $arguments );
                }
            } while (true);
        }

        /**
         * Adds a single command to the bot.
         *
         * @param IRCCommand $command The command to add.
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        public function addCommand( IRCCommand $command ) {
            $commandName = explode( '\\', get_class( $command ) );
            $commandName = $commandName[count( $commandName ) - 1];
            $this->commands[$commandName] = $command;
            $this->log( 'The following Command was added to the Bot: "' . $commandName . '".', 'INFO' );
        }

        /**
         * Displays stuff to the broswer and sends data to the server.
         * @param string $cmd The command to execute.
         *
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        public function sendDataToServer( $cmd ) {
            $this->log( $cmd, 'COMMAND' );
            fputs( $this->socket, $cmd . "\r\n" );
        }

        /**
         * Joins a channel, used in the join function.
         * @param type $channel
         *
         * @author Super3boy <admin@wildphp.com>
         */
        private function join_channel( $channel ) {
            if (is_array( $channel )) {
                foreach ($channel as $chan) {
                    $this->sendDataToServer( 'JOIN ' . $chan );
                }
            }
            else {
                $this->sendDataToServer( 'JOIN ' . $channel );
            }
        }

        /**
         * Adds a log entry to the log file.
         *
         * @param string $log    The log entry to add.
         * @param string $status The status, used to prefix the log entry.
         *
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        private function log( $log, $status = '' ) {
            if (empty( $status )) {
                $status = 'LOG';
            }
            fwrite( $this->logFileHandler, date( 'd.m.Y - H:i:s' ) . "\t  [ " . $status . " ] \t" . FunctionCollection::removeLineBreaks( $log ) . "\r\n" );
        }

    }
?>