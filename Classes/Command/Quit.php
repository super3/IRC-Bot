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
    protected $help = 'Shut the bot down.';

    /**
     * How to use the command.
     *
     * @var string
     */
    protected $usage = '!quit';
    
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
    protected $numberOfArguments = array(0, -1);

    /**
     * Leave IRC altogether. This disconnects from the server.
     */
    public function command() {
        if (count($this->arguments) == 0) {
            $message = 'Quit: WildPHP <http://wildphp.com/>';
        }
        else {
            $message = trim(preg_replace('/\s\s+/', ' ',  implode(' ', $this->arguments)));
        }

        $this->connection->sendData('QUIT :' . $message);
        exit;
    }
}
?>