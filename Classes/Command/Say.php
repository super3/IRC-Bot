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
class Say extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = '!say [#channel|username] whatever you want to say';

    /**
     * The number of arguments the command needs.
     *
     * @var integer
     */
    protected $numberOfArguments = -1;

    /**
     * Sends the arguments to the channel, like say from a user.
     *
     * IRC-Syntax: PRIVMSG [#channel]or[user] : [message]
     */
    public function command() {
        $this->say(implode( ' ', array_slice( $this->arguments, 1 ) ));
    }
}
?>