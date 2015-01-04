<?php
// Namespace
namespace Command;

/**
 * The bot disconnects for the specified number of seconds
 * arguments[0] == Number of seconds to disconnect.
 *
 * @package IRCBot
 * @subpackage Command
 * @author Super3 <admin@wildphp.com>
 */
class Timeout extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = '!timeout [seconds]';

    /**
     * The number of arguments the command needs.
     *
     * You have to define this in the command.
     *
     * @var integer
     */
    protected $numberOfArguments = 1;
    
    /**
     * Verify the user before executing this command.
     *
     * @var bool
     */
    protected $verify = true;

    /**
     * The bot disconnects for the specified number of seconds.
     */
    public function command() {
        // Quit, sleep, and reconnect ( CLI and HTML )
        $this->connection->sendData('QUIT');
        sleep( (int)($this->arguments[0]) );
        $this->bot->connectToServer();
    }
}
?>