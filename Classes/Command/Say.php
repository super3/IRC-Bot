<?php
// Namespace
namespace Command;

/**
 * Sends the arguments to the channel, like say from a user.
 * arguments[0] == Channel or User to say message to.
 * arguments[1] == Message text.
 *
 * @package IRCBot
 * @subpackage Command
 * @author Daniel Siepmann <coding.layne@me.com>
 */
class Say extends \Library\IRCCommand {
    /**
     * Sends the arguments to the channel, like say from a user.
     */
    public function command() {
        // Server: PRIVMSG [#channel]or[user] : [message]
        $this->IRCBot->sendDataToServer( 'PRIVMSG ' . $this->arguments[0] . ' : ' .
        implode( ' ', array_slice( $this->arguments, 1 ) ) );
    }
}
?>