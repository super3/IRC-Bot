<?php
// Namespace
namespace Command;

/**
 * Serialises the bot when the command is issued.
 *
 * @package IRCBot
 * @subpackage Command
 * @author Jack Blower <Jack@elvenspellmaker.co.uk>
 */
class Serialise extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = '!serialise';

    /**
     * The number of arguments the command needs.
     *
     * @var integer
     */
    protected $numberOfArguments = 0;

    /**
     * Sends the arguments to the channel, like say from a user.
     *
     * IRC-Syntax: PRIVMSG [#channel]or[user] : [message]
     */
    public function command() {
        $this->bot->serialise();
		
		preg_match("/(.+)!/", $this->privSource, $queryUser);
		$queryUser = $queryUser[1];
		
		$this->say($queryUser .": I've finished serialising now!~ ^-^");
    }
}
?>