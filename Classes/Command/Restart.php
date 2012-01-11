<?php
// Namespace
namespace Command;

/**
 * Restarts the bot using a http refresh.
 *
 * @package IRCBot
 * @subpackage Command
 * @author Super3 <admin@wildphp.com>
 */
class Restart extends \Library\IRCCommand {
    /**
     * Restarts the bot using a http refresh.
     */
    public function command() {
        $this->IRCBot->sendDataToServer('QUIT');
        // Restart HTML
//        echo "<meta http-equiv=\"refresh\" content=\"3\">";

        // Restart CLI
        $this->IRCBot->connectToServer();
    }
}
?>