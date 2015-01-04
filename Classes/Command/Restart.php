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
     * Restarts the bot.
     */
    public function command() {
        // Exit from Sever
        $this->connection->sendData('QUIT :Restarting...');
		
		// Wait 5 Seconds Before Rejoin
		sleep(5);
		
        // Reconnect to Server
        $this->bot->connectToServer();
    }
}
?>