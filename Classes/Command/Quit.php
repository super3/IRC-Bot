<?php
// Namespace
namespace Command;
// Leave IRC altogether. This disconnects from the server.
class Quit extends \Library\IRCCommand {
    public function command() {
        $this->IRCBot->sendDataToServer('QUIT QUIT. PHP Bot by WildPHP.com');
        exit;
    }
}
?>