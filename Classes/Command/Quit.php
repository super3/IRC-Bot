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
    protected $help = '!quit';

    /**
     * Leave IRC altogether. This disconnects from the server.
     */
    public function command() {
        $this->connection->sendData('QUIT');
        exit;
    }
}
?>