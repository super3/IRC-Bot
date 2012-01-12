<?php
// Namespace
namespace Command;

/**
 * Restarts the bot.
 *
 * @package IRCBot
 * @subpackage Command
 * @author Super3 <admin@wildphp.com>
 */
class Restart extends \Library\IRCCommand {
    /**
    * The command's help text.
    *
    * @var string
    */
    protected $help = '!restart';
    
    /**
     * Restarts the bot.
     */
    public function command() {
        // Exit from Sever
        $this->connection->sendData('QUIT');

        // Reconnect to Server
        $this->connection->connect();
    }
}
?>