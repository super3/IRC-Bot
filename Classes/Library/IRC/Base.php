<?php

/**
 * LICENSE: This source file is subject to Creative Commons Attribution
 * 3.0 License that is available through the world-wide-web at the following URI:
 * http://creativecommons.org/licenses/by/3.0/.  Basically you are free to adapt
 * and use this script commercially/non-commercially. My only requirement is that
 * you keep this header as an attribution to my work. Enjoy!
 *
 * @license http://creativecommons.org/licenses/by/3.0/
 *
 * @package IRCBot
 * @subpackage Library
 * @author Hoshang Sadiq <superaktieboy@gmail.com>
 *
 * @filesource
 */

namespace Library\IRC;

/**
 * A base class for the Command and Listener base to prevent code repetition.
 * The functions were written by Daniel Siepmann, they were just moved around
 *
 * @package IRCBot
 * @subpackage Library
 * @author Hoshang Sadiq <superaktieboy@gmail.com>
 */
abstract class Base
{
    /**
     * Reference to the IRC Connection.
     * @var \Library\IRC\Connection
     * @author Daniel Siepmann <daniel.siepmann@me.com>
     */
    protected $connection = null;

    /**
     * Reference to the IRC Bot
     * @var \Lirary\IRC\Bot
     * @author Daniel Siepmann <daniel.siepmann@me.com>
     */
    protected $bot = null;

    /**
     * Set's the IRC Connection, so we can use it to send data to the server.
     * @param \Library\IRC\Connection $ircConnection
     * @author Daniel Siepmann <daniel.siepmann@me.com>
     */
    public function setIRCConnection( \Library\IRC\Connection $ircConnection ) {
        $this->connection = $ircConnection;
    }

    /**
     * Set's the IRC Bot, so we can use it to send data to the server.
     * @param \Library\IRCBot $ircBot
     * @author Daniel Siepmann <daniel.siepmann@me.com>
     */
    public function setIRCBot( \Library\IRC\Bot $ircBot ) {
        $this->bot = $ircBot;
    }

    /**
     * Fetches data from $uri
     *
     * @param string $uri
     * @return string
     * @author Daniel Siepmann <daniel.siepmann@me.com>
     */
    protected function fetch($uri) {
        $this->bot->log("Fetching from URI: " . $uri);

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $uri);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);
        $this->bot->log("Data fetched: " . $output);

        return $output;
    }

    /**
     * Sends PRIVMSG to source with $msg
     *
     * @param string $msg
     * @author Daniel Siepmann <daniel.siepmann@me.com>
     */
    protected function say($msg, $source = "default") {
        $privNick = explode("!", $this->privSource); // Split into nickname and user/host name.
        $privNick = $privNick[0]; // We only want the nickname.

        $toNick = ($this->source == $this->bot->getNick()) ? $privNick : $this->source; // If the message was a private one then forward back to the messaging user rather than ourself!

        $toNick = ($source == "default") ? $toNick : $source;

        $this->connection->sendData('PRIVMSG '. $toNick .' :'. $msg);
    }
}

?>