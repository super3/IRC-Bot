<?php
// Namespace
namespace Command;

/**
 * Sends the joke to the channel.
 * arguments[0] == Channel or User to say message to.
 *
 * @package IRCBot
 * @subpackage Command
 * @author Matej Velikonja <matej@velikonja.si>
 */
class Joke extends \Library\IRC\Command\Base {
    /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = '!joke';

    /**
     * The number of arguments the command needs.
     *
     * @var integer
     */
    protected $numberOfArguments = 0;

    /**
     * Sends the arguments to the channel. A random joke.
     *
     * IRC-Syntax: PRIVMSG [#channel]or[user] : [message]
     */
    public function command() {


        $this->bot->log("Fetching joke.");

        $data = $this->fetch("http://api.icndb.com/jokes/random");

        $joke = json_decode($data);

        if ($joke) {
            if (isset($joke->value->joke)) {
                $this->say($joke->value->joke);
            }
        } else {
            $this->say("I don't feel like laughing today. :(");
        }
    }
}