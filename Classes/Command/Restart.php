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
     * Restarts the bot. 
     */
    public function command() {
        // Exit from Sever
        $this->IRCBot->sendDataToServer('QUIT');

        // Reconnect to Server
        $this->IRCBot->connectToServer();
    }
}
?>