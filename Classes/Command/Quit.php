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
class Quit extends \Library\IRCCommand {
    /**
     * Leave IRC altogether. This disconnects from the server.
     */
    public function command() {
        $this->connection->sendData('QUIT');
        exit;
    }
}
?>