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
    * The number of arguments the command needs.
    *
    * @var integer
    */
    protected $numberOfArguments = 1;

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