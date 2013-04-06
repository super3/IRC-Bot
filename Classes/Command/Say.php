<?php
// Namespace
namespace Command;

/**
 * Sends the arguments to the channel, like say from a user.
 *
 * @package WildBot
 * @subpackage Command
 * @author Daniel Siepmann <coding.layne@me.com>
 */
class Say extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     * arguments[0] == Channel or User to say message to.
     * arguments[1] == Message text.
     *
     * @var string
     */
    protected $help = '!say [#channel|username] whatever you want to say';
    
    /**
     * The number of arguments the command needs.
     *
     * @var integer
     */
    protected $maxArgs = -1;

    /**
     * Require admin, set to true if only admin may execute this.
     * @var boolean
     */
    protected $requireAdmin = true;
    
    /**
     * Sends the arguments to the channel, like say from a user.
     *
     * IRC-Syntax: PRIVMSG [#channel]or[user] : [message]
     */
    public function command() {
        $this->say( implode( ' ', array_slice( $this->arguments, 1 ) ), $this->arguments[0] );
    }
}
