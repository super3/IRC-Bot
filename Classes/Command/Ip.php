<?php
// Namespace
namespace Command;

/**
 * Sends the user's IP to the channel.
 *
 * @package WildBot
 * @subpackage Command
 * @author Matej Velikonja <matej@velikonja.si>
 */
class Ip extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = '!ip';
    
    /**
     * Sends the arguments to the channel.
     * An IP.
     *
     * IRC-Syntax: PRIVMSG [#channel]or[user] : [message]
     */
    public function command() {
        $ip = $this->getUserIp();
        
        if ( $ip ) {
            $this->say( 'Your IP is: ' . $ip );
        } else {
            $this->say( 'You don\'t have an IP' );
        }
    }
}