<?php
// Namespace
namespace Command;
// Restarts the bot using a http refresh.
class Restart extends \Library\IRCCommand {
    public function command() {
        $this->IRCBot->sendDataToServer('QUIT RESTARTING. PHP Bot by WildPHP.com');
        $this->IRCBot->connectToServer();
        exit;
    }
}
?>