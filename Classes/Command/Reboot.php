<?php
// Namespace
namespace Command;

/**
 * Reboots the bot.
 *
 * @package IRCBot
 * @subpackage Command
 * @author Super3 <admin@wildphp.com>
 */
class Reboot extends \Library\IRCCommand {
    /**
    * The command's help text.
    *
    * @var string
    */
    protected $help = '!reboot';
    
    /**
     * Reboots the bot.
     * 
     * When running from a browser page the bot roboots using
     * a HTTP refresh with a three second delay.
     * 
     * Currently trying to figure out an implementation that
     * would allow the bot to restart via a CLI.
     */
    public function command() {
        // Restart Browser Page
        echo "<meta http-equiv=\"refresh\" content=\"3\">";
        exit;
       
        // TODO: Restart CLI
        $this->connection->sendData('QUIT');
        $this->connection->connect();
    }
}
?>