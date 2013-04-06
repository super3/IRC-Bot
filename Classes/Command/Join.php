<?php
// Namespace
namespace Command;

/**
 * Joins the specified channel.
 *
 * @package WildBot
 * @subpackage Command
 * @author Super3 <admin@wildphp.com>
 */
class Join extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = '!join {[#channel],<password>} {[#channel],<password>} etc';
    
    /**
     * The number of arguments the command needs.
     *
     * @var integer
     */
    protected $maxArgs = -1;

    /**
     * Require admin, set to true if only admin may execute this.
     * @var boolean
     */
    protected $requireAdmin = true;
    
    /**
     * Joins the specified channel.
     *
     * IRC-Syntax: JOIN [#channel]
     */
    public function command() {
        foreach ( $this->arguments as $arg ) {
            $args = explode( ',', $arg );
            $this->connection->sendData( 'JOIN ' . $args[0] . ' ' . $args[1] );
        }
    }
}
