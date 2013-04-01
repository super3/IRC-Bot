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
abstract class Base {
    /**
     * Reference to the IRC Connection.
     * 
     * @var \Library\IRC\Connection
     */
    protected $connection = null;
    
    /**
     * Reference to the IRC Bot
     * 
     * @var \Lirary\IRC\Bot
     */
    protected $bot = null;
    
    /**
     * Contains the arugments
     * @var array
     */
    protected $args = null;
    
    /**
     * Contains the nick/host/username of the user who issued the command.
     * 
     * @var string
     */
    protected $privSource = null;
    
    /**
     * Contains channel or user name
     *
     * @var string
     */
    protected $source = null;
    
    /**
     * Original request from server
     *
     * @var string
     */
    protected $data;
    
    /**
     * Contains all given arguments.
     * 
     * @var array
     */
    protected $arguments = array ();
    
    /**
     * Set's the IRC Connection, so we can use it to send data to the server.
     * 
     * @param \Library\IRC\Connection $ircConnection            
     * @author Daniel Siepmann <daniel.siepmann@me.com>
     */
    public function setIRCConnection(\Library\IRC\Connection $ircConnection ) {
        $this->connection = $ircConnection;
        return $this;
    }
    
    /**
     * Set's the IRC Bot, so we can use it to send data to the server.
     * 
     * @param \Library\IRCBot $ircBot            
     * @author Daniel Siepmann <daniel.siepmann@me.com>
     */
    public function setIRCBot(\Library\IRC\Bot $ircBot ) {
        $this->bot = $ircBot;
        return $this;
    }
    
    /**
     * Set the arguments for the current message
     * This will also populate some fields
     * 
     * @param array $args            
     * @return \Library\IRC\Base
     */
    public function setArgs( $args ) {
        $this->data = implode( ' ', $args );
        $this->privSource = substr( trim( \Library\FunctionCollection::removeLineBreaks( $args[0] ) ), 1 );
        $this->source = substr( trim( \Library\FunctionCollection::removeLineBreaks( $args[2] ) ), 0 );
        $this->command = substr( trim( \Library\FunctionCollection::removeLineBreaks( $args[3] ) ), 1 );
        $this->arguments = count( $args ) > 4 ? array_slice( $args, 4 ) : array ();
        
        $this->args = $args;
        return $this;
    }
    
    /**
     * Returns parsed args of
     * 
     * @param string $data            
     * @return array
     */
    protected function getInfo() {
        $args = $this->args;
        
        /*
         * Strip leading colons off messages (that are meant to be seen by IRC only), only look at
         * the first three elements to avoid cutting off a user who starts an argument with a colon.
         * Corrects :test!example@example.com PRIVMSG #cs :foo bar :baz ::: to test!example@example.com
         * PRIVMSG #cs foo bar :baz :::
         * This is useful because it means listener writers don't have to
         * manually remove these characters (which is what Joins.php was doing).
         */
        for ( $i = 0; $i <= ( ( ( sizeof( $args ) - 1 ) < 3 ) ? ( sizeof( $args ) - 1 ) : 3 ); $i++ )
            $args[$i] = ( strpos( $args[$i], ":" ) === 0 ) ? substr( $args[$i], 1 ) : $args[$i];
        
        $args = array_map( function ( $value ) {
            return trim( \Library\FunctionCollection::removeLineBreaks( $value ) );
        }, $args );
        
        $msg = array_slice( $args, 3 );
        $msgtext = implode( ' ', $msg );
        return (object) array ('user' => $args[0],'nick' => $this->getUserNickName( $args[0] ),'command' => $args[1],'channel' => $args[2],'addressing_bot' => strpos( $msgtext, $this->bot->getNick() ) !== false,'message' => $msgtext,'arguments' => $msg 
        );
        
        return $args;
    }
    
    /**
     * Get the user nickname
     * @param string $user
     * @return string|boolean
     */
    private function getUserNickName( $user ) {
        $result = preg_match( '/([a-zA-Z0-9_]+)!/', $user, $matches );
        
        if ( $result !== false ) {
            return $matches[1];
        }
        
        return false;
    }

    /**
     * Get the arguments from the last chat
     * @return array
     */
    public function getArgs() {
        return $this->args;
    }
    
    /**
     * Sends PRIVMSG to source with $msg
     *
     * @param string $msg            
     * @author Daniel Siepmann <daniel.siepmann@me.com>
     */
    protected function say( $msg, $source = "default" ) {
        $privNick = $this->getInfo()->nick; // We only want the nickname.

        // If the message was a private one then forward back
        // to the messaging user rather than ourself!
        $toNick = ( $this->source == $this->bot->getNick() ) ? $privNick : $this->source; 
        
        $toNick = ( $source == "default" ) ? $toNick : $source;
        
        $this->connection->sendData( 'PRIVMSG ' . $toNick . ' :' . $msg );
    }
    
    /**
     * Fetches data from $uri
     *
     * @param string $uri            
     * @return string
     * @author Daniel Siepmann <daniel.siepmann@me.com>
     */
    protected function fetch( $uri ) {
        $this->bot->log( "Fetching from URI: " . $uri );
        
        // create curl resource
        $ch = curl_init();
        
        // set url
        curl_setopt( $ch, CURLOPT_URL, $uri );
        
        // return the transfer as a string
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_FRESH_CONNECT, 1 );
        
        // $output contains the output string
        $output = curl_exec( $ch );
        
        // close curl resource to free up system resources
        curl_close( $ch );
        $this->bot->log( "Data fetched: " . $output );
        
        return $output;
    }
}
>>>>>>> b2fdda7db383844d8ae3bbbe9c644c7c2e8622b2
