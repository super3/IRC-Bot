<?php
// Namespace
namespace Command;

/**
 * Restarts the bot.
 *
 * @package IRCBot
 * @subpackage Command
 * @author Super3 <admin@wildphp.com>
 */
class Restart extends \Library\IRC\Command\Base {
    /**
    * The command's help text.
    *
    * @var string
    */
    protected $help = '!restart';
    
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
     * Restarts the bot.
     */
    public function command() {
        if (count($this->arguments) == 0) {
            $message = 'Restarting...';
        }
        else {
            $message = trim(preg_replace('/\s\s+/', ' ',  implode(' ', $this->arguments)));
        }
        
        // Exit from Sever
        $this->connection->sendData('QUIT :' . $message);

        // Wait 5 Seconds Before Rejoin
        sleep(5);

        // Reconnect to Server
        $this->bot->connectToServer();
    }
}
?>