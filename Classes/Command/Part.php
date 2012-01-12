<?php
// Namespace
namespace Command;

/**
 * Parts the specified channel. 
 * arguments[0] == Channel to part.
 * 
 * @package IRCBot
 * @subpackage Command
 * @author Super3 <admin@wildphp.com>
 */
class Part extends \Library\IRCCommand {
    /**
    * The command's help text.
    *
    * @var string
    */
    protected $help = '!part [#channel]';

    /**
     * Parts the specified channel. 
     * 
     * IRC-Syntax: JOIN [#channel]
     */
    public function command() {
        $this->connection->sendData('PART '.$this->arguments[0]);
    }
}
?>