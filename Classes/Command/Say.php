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
     * The number of arguments the command needs.
     *
     * @var integer
     */
    protected $numberOfArguments = -1;
    
     /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = '!say [#channel]or[user] [message]';

    /**
     * Sends the arguments to the channel, like say from a user.
     *
     * IRC-Syntax: PRIVMSG [#channel]or[user] : [message]
     */
    public function command() {
        $this->connection->sendData(
            'PRIVMSG ' . $this->arguments[0] . ' : ' .
            implode( ' ', array_slice( $this->arguments, 1 ) )
        );
    }
}
?>