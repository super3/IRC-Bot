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
class Join extends \Library\IRC\Command\Base {
    /**
    * The command's help text.
    *
    * @var string
    */
    protected $help = '!join [#channel]';

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
     * Joins the specified channel.
     *
     * IRC-Syntax: JOIN [#channel]
     */
    public function command() {
        $this->connection->sendData('JOIN '.$this->arguments[0]);
    }
}
?>