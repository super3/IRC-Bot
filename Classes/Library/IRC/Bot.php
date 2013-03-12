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
 * @subpackage Library
 *
 * @encoding UTF-8
 * @created 30.12.2011 20:29:55
 *
 * @author Daniel Siepmann <coding.layne@me.com>
 */

namespace Library\IRC;

/**
 * A simple IRC Bot with basic features.
 *
 * @package IRCBot
 * @subpackage Library
 *
 * @author Super3 <admin@wildphp.com>
 * @author Daniel Siepmann <coding.layne@me.com>
 */
class Bot {

    /**
     * Holds the server connection.
     * @var \Library\IRC\Connection
     */
    private $connection = null;

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
     * All available listeners.
     * Listeners are type of IRCListener
     * @var array
     */
    private $listeners = array ( );

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
    public function __construct( array $configuration = array ( ) ) {

        $this->connection = new \Library\IRC\Connection\Socket;

        if (count( $configuration ) === 0) {
            return;
        }

        $this->setWholeConfiguration( $configuration );
    }

    /**
     * Cleanup handlers.
     */
    public function __destruct() {
        if ($this->logFileHandler) {
            fclose( $this->logFileHandler );
        }
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

        if ($this->connection->isConnected()) {
            $this->connection->disconnect();
        }

        $this->log( 'The following commands are known by the bot: "' . implode( ',', array_keys( $this->commands ) ) . '".', 'INFO' );
        $this->log( 'The following listeners are known by the bot: "' . implode( ',', array_keys( $this->listeners ) ) . '".', 'INFO' );

        $this->connection->connect();
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
            $data = $this->connection->getData();

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
                $this->connection->connect();
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
            if ($args[0] == 'PING' || !isset($args[1])) {
                continue;
            }

            /* @var $listener \Library\IRC\Listener\Base */
            foreach ($this->listeners as $listener) {
                if (is_array($listener->getKeywords())) {
                    foreach ($listener->getKeywords() as $keyword) {
                        //compare listeners keyword and 1st arguments of server response
                        if ($keyword === $args[1]) {
                            $listener->execute( $data );
                        }
                    }
                }
            }

            if (isset($args[3])) {
                // Explode the server response and get the command.
                // $source finds the channel or user that the command originated.
                $source = substr( trim( \Library\FunctionCollection::removeLineBreaks( $args[2] ) ), 0 );
                $command = substr( trim( \Library\FunctionCollection::removeLineBreaks( $args[3] ) ), 1 );
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

                    $this->executeCommand( $source, $command, $arguments, $data );
                }
            }
        } while (true);
    }

    /**
     * Adds a single command to the bot.
     *
     * @param IRCCommand $command The command to add.
     * @author Daniel Siepmann <coding.layne@me.com>
     */
    public function addCommand( \Library\IRC\Command\Base $command ) {
        $commandName = $this->getClassName($command);
        $command->setIRCConnection( $this->connection );
        $command->setIRCBot( $this );
        $this->commands[$commandName] = $command;
        $this->log( 'The following Command was added to the Bot: "' . $commandName . '".', 'INFO' );
    }

    protected function executeCommand( $source, $commandName, array $arguments, $data ) {
        // Execute command:
        $command = $this->commands[$commandName];
        /** @var $command IRCCommand */
        $command->executeCommand( $arguments, $source, $data );
    }

    public function addListener( \Library\IRC\Listener\Base $listener) {
        $listenerName = $this->getClassName($listener);
        $listener->setIRCConnection( $this->connection );
        $listener->setIRCBot( $this );
        $this->listeners[$listenerName] = $listener;
        $this->log( 'The following Listener was added to the Bot: "' . $listenerName . '".', 'INFO' );
    }

    /**
     * Returns class name of $object without namespace
     *
     * @param mixed $object
     * @author Matej Velikonja <matej@velikonja.si>
     * @return string
     */
    private function getClassName( $object) {
        $objectName = explode( '\\', get_class( $object ) );
        $objectName = $objectName[count( $objectName ) - 1];

        return $objectName;
    }

    /**
     * Displays stuff to the broswer and sends data to the server.
     * @param string $cmd The command to execute.
     *
     * @author Daniel Siepmann <coding.layne@me.com>
     */
    public function sendDataToServer( $cmd ) {
        $this->log( $cmd, 'COMMAND' );
        $this->connection->sendData( $cmd );
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
    public function log( $log, $status = '' ) {
        if (empty( $status )) {
            $status = 'LOG';
        }

        $msg = date( 'd.m.Y - H:i:s' ) . "\t  [ " . $status . " ] \t" . \Library\FunctionCollection::removeLineBreaks( $log ) . "\r\n" ;

        echo $msg;

        if (!is_null( $this->logFileHandler )) {
            fwrite( $this->logFileHandler, $msg);
        }
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
        $this->setMaxReconnects( $configuration['maxReconnects'] );
        $this->setLogFile( $configuration['logFile'] );
    }

    /**
     * Sets the server.
     * E.g. irc.quakenet.org or irc.freenode.org
     * @param string $server The server to set.
     */
    public function setServer( $server ) {
        $this->connection->setServer( $server );
    }

    /**
     * Sets the port.
     * E.g. 6667
     * @param integer $port The port to set.
     */
    public function setPort( $port ) {
        $this->connection->setPort( $port );
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
            $logFilePath = dirname( $this->logFile );
            if (!is_dir( $logFilePath )) {
                mkdir( $logFilePath, 0777, true );
            }
            $this->logFile .= date( 'd-m-Y' ) . '.log';
            $this->logFileHandler = fopen( $this->logFile, 'w+' );
        }
    }

    public function getCommands() {
        return $this->commands;
    }

    public function getCommandPrefix() {
        return $this->commandPrefix;
    }
}
?>