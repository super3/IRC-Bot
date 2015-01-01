<?php
namespace Library\IRC\Listener;

abstract class Base
{
    /**
     * Reference to the IRC Connection.
     * @var \Library\IRC\Connection
     */
    protected $connection = null;

    /**
     * Reference to the IRC Bot
     * @var \Library\IRC\Bot
     */
    protected $bot = null;

    abstract function execute($data);

    /**
     * Returns keywords that listener is listening to.
     *
     * @return array
     */
    abstract function getKeywords();

    /**
     * Sends PRIVMSG to source with $msg
     *
     * @param string $msg
     */
    protected function say($msg, $source) {
        $this->connection->sendData(
                'PRIVMSG ' . $source . ' :' . $msg
        );
    }

    /**
     * Set's the IRC Connection, so we can use it to send data to the server.
     * @param \Library\IRC\Connection $ircConnection
     */
    public function setIRCConnection( \Library\IRC\Connection $ircConnection ) {
        $this->connection = $ircConnection;
    }

    /**
     * Set's the IRC Bot, so we can use it to send data to the server.
     * @param \Library\IRCBot $ircBot
     */
    public function setIRCBot( \Library\IRC\Bot $ircBot ) {
        $this->bot = $ircBot;
    }

    /**
     *
     * @param string $data
     * @return array
     */
    protected function getArguments($data) {
        $args = explode( ' ', $data );
        $func = function($value) {
            return trim( \Library\FunctionCollection::removeLineBreaks( $value ) );
        };

        return array_map($func, $args);
    }
}
