<?php
// Namespace
namespace Command;

/**
 * Leave IRC altogether. This disconnects from the server.
 *
 * @package IRCBot
 * @subpackage Command
 * @author Daniel Siepmann <coding.layne@me.com>
 */
class Quit extends \Library\IRC\Command\Base {
    /**
    * The command's help text.
    *
    * @var string
    */
    protected $help = '!quit';
    
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
    protected $numberOfArguments = 0;

    /**
     * Leave IRC altogether. This disconnects from the server.
     */
    public function command() {
        $this->connection->sendData('QUIT');
        exit;
    }
}
?>