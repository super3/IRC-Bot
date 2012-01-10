<?php
// Namespace
namespace Command;
// Restarts the bot using a http refresh.
class Restart extends \Library\IRCCommand {
    public function command() {
        $this->IRCBot->sendDataToServer('QUIT');
        // Restart HTML
        echo "<meta http-equiv=\"refresh\" content=\"3\">";
        exit;
    }
}
?>