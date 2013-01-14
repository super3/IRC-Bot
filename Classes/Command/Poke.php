<?php
// Namespace
namespace Command;

/**
 * Sends the arguments to the channel, like say from a user.
 * arguments[0] == Channel or User to send Poke to.
 * arguments[1] == Poke Victim.
 *
 * @package IRCBot
 * @subpackage Command
 * @author Super3 <admin@wildphp.com>
 */
class Poke extends \Library\IRC\Command\Base {
    /**
    * The command's help text.
    *
    * @var string
    */
    protected $help = '!poke [#channel]or[user] [user]';

    /**
     * The number of arguments the command needs.
     *
     * You have to define this in the command.
     *
     * @var integer
     */
    protected $numberOfArguments = 2;

    /**
     * Sends the arguments to the channel, like say from a user.
     *
     * IRC-Syntax: PRIVMSG [#channel]or[user] :0x01Action pokes [User]0x01
     * 0x01 or the chr(1) represents "Start of Heading" which is a
     * control charater. This is needed to send the ACTION command, but
     * it not needed when sending a regular text message.
     */
    public function command() {
        $this->connection->sendData(
            'PRIVMSG ' . $this->arguments[0] .
            ' :'. chr(1). 'ACTION pokes '. trim($this->arguments[1]). chr(1)
        );
    }
}
?>