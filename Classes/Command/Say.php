<?php
// Namespace
namespace Command;
//Sends the arguments to the channel, like say from a user.
// arguments[0] == Channel or User to say message to.
// arguments[1] == Message text.
class Say extends \Library\IRCCommand {
    public function command() {
        $this->IRCBot->sendDataToServer( 'PRIVMSG ' . $this->arguments[0] . ' : ' .
        implode( ' ', array_slice( $this->arguments, 1 ) ) );
    }
}
?>