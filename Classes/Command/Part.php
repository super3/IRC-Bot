<?php
// Namespace
namespace Command;

/**
 * Parts the specified channel.
 *
 * @package WildBot
 * @subpackage Command
 * @author Super3 <admin@wildphp.com>
 */
class Part extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = '!part [#channel]';
    
    /**
     * The number of arguments the command needs.
     *
     * You have to define this in the command.
     *
     * @var integer
     */
    protected $maxArgs = 1;

    /**
     * Require admin, set to true if only admin may execute this.
     * @var boolean
     */
    protected $requireAdmin = true;
    
    /**
     * Parts the specified channel.
     *
     * IRC-Syntax: JOIN [#channel]
     */
    public function command() {
        $this->connection->sendData( 'PART ' . $this->arguments[0] );
    }
}
