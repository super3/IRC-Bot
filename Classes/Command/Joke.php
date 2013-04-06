<?php
// Namespace
namespace Command;

/**
 * Sends the joke to the channel.
 *
 * @package WildBot
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
     * Sends the arguments to the channel.
     * A random joke.
     *
     * IRC-Syntax: PRIVMSG [#channel]or[user] : [message]
     */
    public function command() {
        $this->bot->log( 'Fetching joke.' );
        
        $data = $this->fetch( 'http://api.icndb.com/jokes/random' );
        
        // ICNDB has escaped slashes in JSON response.
        $data = stripslashes( $data );
        
        $joke = json_decode( $data );
        
        if ( $joke && isset( $joke->value->joke ) ) {
            $this->say( html_entity_decode( $joke->value->joke ) );
            return;
        }
        
        $this->say( 'I don\'t feel like laughing today. :(' );
    }
}