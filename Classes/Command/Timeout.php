<?php
// Namespace
namespace Command;

/**
 * The bot disconnects for the specified number of seconds
 * arguments[0] == Number of seconds to disconnect.
 *
 * @package IRCBot
 * @subpackage Command
 * @author Super3 <admin@wildphp.com>
 */
class Timeout extends \Library\IRCCommand {
    /**
     * The bot disconnects for the specified number of seconds.
     */
    public function command() { 
        // Quit, sleep, and reconnect ( CLI and HTML )
        $this->IRCBot->sendDataToServer('QUIT');
        sleep( $this->arguments[0] );
        $this->IRCBot->connectToServer();
    }
}
?>