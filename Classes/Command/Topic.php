<?php
// Namespace
namespace Command;

/**
 * Sets the Topic of the Channel.
 * arguments[0] == Channel or User to say message to.
 *
 * @package IRCBot
 * @subpackage Command
 * @author Tim Vos <timtimss@outlook.com>
 */
class Topic extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = 'Set the topic for a channel. The bot needs to be OP in said channel.';

    /**
     * How to use the command.
     *
     * @var string
     */
    protected $usage = '!topic [optional #channel] [message]';

    /**
     * Verify the user before executing this command.
     *
     * @var bool
     */
    protected $verify = true;

    /**
     * The number of arguments the command needs.
     *
     * @var integer
     */
    protected $numberOfArguments = -1;

    /**
     * Sets the selected channel topic
     */
    public function command() {

		if(strpos($this->arguments[0],'#') !== false){
			$this->connection->sendData('TOPIC ' . $this->arguments[0] . " :" . implode( ' ', array_slice( $this->arguments, 1 ) ));
		} else {
			$this->connection->sendData('TOPIC ' . $this->source . " :" . implode(' ', $this->arguments));
		}
    }
}
