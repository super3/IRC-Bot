<?php
// Namespace
namespace Command;

/**
 * The bot disconnects for the specified number of seconds
 *
 * @package WildBot
 * @subpackage Command
 * @author Super3 <admin@wildphp.com>
 */
class Timeout extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     * arguments[0] == Number of seconds to disconnect.
     *
     * @var string
     */
    protected $help = '!timeout [seconds]';
    
    /**
     * The number of arguments the command needs.
     *
     * You have to define this in the command.
     *
     * @var integer
     */
    protected $maxArgs = 1;

    /**
     * Require admin, set to true if only admin may execute this.
     * @var boolean
     */
    protected $requireAdmin = true;
    
    /**
     * The bot disconnects for the specified number of seconds.
     */
    public function command() {
        // Quit, sleep, and reconnect ( CLI and HTML )
        $this->connection->sendData( 'QUIT' );
        sleep( (int) ( $this->arguments[0] ) );
        $this->bot->connectToServer();
    }
}
