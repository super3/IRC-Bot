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
     * @author     Super3 <admin@wildphp.com>
     * @copyright  2010, The Nystic Network
     * @license    http://creativecommons.org/licenses/by/3.0/
     * @link       http://wildphp.com (Visit for updated versions and more free scripts!)
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
     * @author Super3 <admin@wildphp.com>
     * @author Daniel Siepmann <coding.layne@me.com>
     */
    class IRCBot {

        /**
         * The server you want to connect to.
         * @var string
         */
        private $server = '';

        /**
         * The port of the server you want to connect to.
         * @var integer
         */
        private $port = 0;

        /**
         * A list of all channels the bot should connect to.
         * @var array
         */
        private $channel = array ( );

        /**
         * The name of the bot.
         * @var string
         */
        private $name = '';

        /**
         * The nick of the bot.
         * @var string
         */
        private $nick = '';

        /**
         * The number of reconnects before the bot stops running.
         * @var integer
         */
        private $maxReconnects = 0;

        /**
         * Complete file path to the log file.
         * Configure the path, the filename is generated and added.
         * @var string
         */
        private $logFile = '';

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
         * Creates a new IRCBot.
         *
         * @param array $configuration The whole configuration, you can use the setters, too.
         * @return void
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        public function __construct(array $configuration = array()) {
            if (count( $configuration ) === 0) {
                return;
            }

            $this->setWholeConfiguration( $configuration );
        }

        /**
         * Connects the bot to the server.
         *
         * @author Super3 <admin@wildphp.com>
         * @author Daniel Siepmann <coding.layne@me.com>
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
         *
         * @author Super3 <admin@wildphp.com>
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        private function main() {
            do {
                $command = '';
                $arguments = array ( );
                $data = fgets( $this->socket, 256 );

                // Check for some special situations and react:
                // The nickname is in use, create a now one using a counter and try again.
                if (stripos( $data, 'Nickname is already in use.' ) !== false) {
                    $this->nickToUse = $this->nick . (++$this->nickCounter);
                    $this->sendDataToServer( 'NICK ' . $this->nickToUse );
                }

                // We're welcome. Let's join the configured channel/-s.
                if (stripos( $data, 'Welcome' ) !== false) {
                    $this->join_channel( $this->channel );
                }

                // Something realy went wrong.
                if (stripos( $data, 'Registration Timeout' ) !== false ||
                    stripos( $data, 'Erroneous Nickname' ) !== false ||
                    stripos( $data, 'Closing Link' ) !== false) {
                    // If the error occurs to often, create a log entry and exit.
                    if ($this->numberOfReconnects >= (int) $this->maxReconnects) {
                        $this->log( 'Closing Link after "' . $this->numberOfReconnects . '" reconnects.', 'EXIT' );
                        exit;
                    }

                    // Notice the error.
                    $this->log( $data, 'CONNECTION LOST' );
                    // Wait before reconnect ...
                    sleep( 60 * 1 );
                    ++$this->numberOfReconnects;
                    // ... and reconnect.
                    $this->connectToServer( $this->server, $this->port );
                    return;
                }

                // Get the response from irc:
                $args = explode( ' ', $data );
                $this->log( $data );


                // Play ping pong with server, to stay connected:
                if ($args[0] == 'PING') {
                    $this->sendDataToServer( 'PONG ' . $args[1] );
                }

                // Nothing new from the server, step over.
                if ($args[0] == 'PING' || !isset( $args[3] )) {
                    continue;
                }

                // Explode the server response and get the command.
                $command = substr( trim( FunctionCollection::removeLineBreaks( $args[3] ) ), 1 );
                $arguments = array_slice( $args, 4 );
                unset( $args );

                // Check if the response was a command.
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
         * Joins one or multiple channel/-s.
         * @param mixed $channel An string or an array containing the name/-s of the channel.
         *
         * @author Super3 <admin@wildphp.com>
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
            if (is_null( $this->logFileHandler )) {
                return false;
            }
            if (empty( $status )) {
                $status = 'LOG';
            }
            fwrite( $this->logFileHandler, date( 'd.m.Y - H:i:s' ) . "\t  [ " . $status . " ] \t" . FunctionCollection::removeLineBreaks( $log ) . "\r\n" );
        }


        // Setters

        /**
         * Sets the whole configuration.
         *
         * @param array $configuration The whole configuration, you can use the setters, too.
         * @author Daniel Siepmann <coding.layne@me.com>
         */
        private function setWholeConfiguration( array $configuration ) {
            $this->setServer( $configuration['server'] );
            $this->setPort( $configuration['port'] );
            $this->setChannel( $configuration['channel'] );
            $this->setName( $configuration['name'] );
            $this->setNick( $configuration['nick'] );
            $this->setMaxReconnects( $configuration['macReconnects'] );
            $this->setLogFile( $configuration['logFile'] );
        }

        /**
         * Sets the server.
         * E.g. irc.quakenet.org or irc.freenode.org
         * @param string $server The server to set.
         */
        public function setServer( $server ) {
            $this->server = (string) $server;
        }

        /**
         * Sets the port.
         * E.g. 6667
         * @param integer $port The port to set.
         */
        public function setPort( $port ) {
            $this->port = (int) $port;
        }

        /**
         * Sets the channel.
         * E.g. '#testchannel' or array('#testchannel','#helloWorldChannel')
         * @param string|array $channel The channel as string, or a set of channels as array.
         */
        public function setChannel( $channel ) {
            $this->channel = (array) $channel;
        }

        /**
         * Sets the name of the bot.
         * "Yes give me a name!"
         * @param string $name The name of the bot.
         */
        public function setName( $name ) {
            $this->name = (string) $name;
        }

        /**
         * Sets the nick of the bot.
         * "Yes give me a nick too. I love nicks."
         *
         * @param string $nick The nick of the bot.
         */
        public function setNick( $nick ) {
            $this->nick = (string) $nick;
        }

        /**
         * Sets the limit of reconnects, before the bot exits.
         * @param integer $maxReconnects The number of reconnects before the bot exits.
         */
        public function setMaxReconnects( $maxReconnects ) {
            $this->maxReconnects = (int) $maxReconnects;
        }

        /**
         * Sets the filepath to the log. Specify the folder and a prefix.
         * E.g. /Users/yourname/logs/ircbot- That will result in a logfile like the following:
         * /Users/yourname/logs/ircbot-11-12-2012.log
         *
         * @param string $logFile The filepath and prefix for a logfile.
         */
        public function setLogFile( $logFile ) {
            $this->logFile = (string) $logFile;
            if (!empty( $this->logFile )) {
                $logFilePath = basename( $this->logFile );
                if (!is_dir( $logFilePath )) {
                    mkdir( $logFilePath, 0777, true );
                }
                $this->logFile .= date( 'd-m-Y' ) . '.log';
                $this->logFileHandler = fopen( $this->logFile, 'w+' );
            }
        }

    }
?>