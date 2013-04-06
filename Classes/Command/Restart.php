<?php
// Namespace
namespace Command;

/**
 * Restarts the bot.
 *
 * @package WildBot
 * @subpackage Command
 * @author Super3 <admin@wildphp.com>
 */
class Restart extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = '!restart';

    /**
     * Require admin, set to true if only admin may execute this.
     * @var boolean
     */
    protected $requireAdmin = true;
    
    /**
     * Restarts the bot.
     */
    public function command() {
        // Exit from Sever
        $this->connection->sendData( 'QUIT' );
        
        // Reconnect to Server
        $this->bot->connectToServer();
    }
}
