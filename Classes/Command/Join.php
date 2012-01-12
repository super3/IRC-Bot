<?php
// Namespace
namespace Command;

/**
 * Joins the specified channel. 
 * arguments[0] == Channel to join.
 * 
 * @package IRCBot
 * @subpackage Command
 * @author Super3 <admin@wildphp.com>
 */
class Join extends \Library\IRCCommand {
    /**
    * The command's help text.
    *
    * @var string
    */
    protected $help = '!join [#channel]';

    /**
     * Joins the specified channel. 
     * 
     * IRC-Syntax: JOIN [#channel]
     */
    public function command() {
        $this->connection->sendData('JOIN '.$this->arguments[0]);
    }
}
?>