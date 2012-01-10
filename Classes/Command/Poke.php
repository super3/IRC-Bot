<?php
// Namespace
namespace Command;
//Sends the arguments to the channel, like say from a user.
// arguments[0] == Channel or User to say message to.
// arguments[1] == Message text.
class Poke extends \Library\IRCCommand {
    public function command() {
        $this->IRCBot->sendDataToServer( 'PRIVMSG ' . $this->arguments[0] . ' :'. chr(1). 'ACTION pokes '.
        $this->arguments[1]. chr(1) );
    }
}
?>