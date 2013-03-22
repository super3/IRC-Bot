<?php
    /**
     * IRC Bot
     *
     * LICENSE: This source file is subject to Creative Commons Attribution
     * 3.0 License that is available through the world-wide-web at the following URI:
     * http://creativecommons.org/licenses/by/3.0/.  Basically you are free to adapt
     * and use this script commercially/non-commercially. My only requirement is that
     * you keep this header as an attribution to my work. Enjoy!
     *
     * @license    http://creativecommons.org/licenses/by/3.0/
     *
     * @package IRCBot
     * @subpackage Library
     * @author Jack Blower <Jack@elevnspellmaker.co.uk
     *
     * @encoding UTF-8
     * @created 16/03/2013
     *
     * @filesource
     */

    namespace Library;

    /**
     * Description of SayRedirection
     *
     * @package IRCBot
     * @subpackage Library
     * @author Jack Blower <Jack@elvenspellmaker.co.uk>
     */
    class SayRedirector {
        protected $bot;
        protected $limit = 3; // If someone tries to get the bot to say more than limit things it will redirect the messages to the person who asked the question rather than the channel they are in.
        
        protected $person =  "";
        protected $channel = "";
        
        protected $messageBuffer = array();
        
        function __construct(\Library\IRC\Bot $bot) { $this->bot = $bot; }

        public function start( $person, $channel ) {
            $this->person = $person;
            $this->channel = $channel;
        }
        
        public function say($message) { $this->messageBuffer[] = $message; }
        
        public function shunt() {
            if( count($this->messageBuffer) > $this->limit )
            {
                $this->sendToBot($this->channel, array($this->person . ': I have sent my response in a PM to reduce channel spam!'));
                $this->sendToBot($this->person, $this->messageBuffer);
            }
            else
                $this->sendToBot($this->channel, $this->messageBuffer);
            
            // Reset all variables! //
            $this->person = "";
            $this->channel = "";
            $this->messageBuffer = array();
            //////////////////////////
        }
        
        /**
         * Sends PRIVMSG to toNick whether it's a channel or a 
         *
         * @param string $toNick
         */
        protected function sendToBot($toNick, $messages) {
            $toNick = ($toNick == $this->bot->getNick()) ? $this->person : $toNick;
            $beginningMsg = 'PRIVMSG '. $toNick .' :';
        
            if(strpos($toNick, '#') === FALSE)
                $this->bot->getConnection()->sendData(
                    $beginningMsg .'These messages originate from '. $this->channel 
                );
            
            foreach( $messages as $msg )
            {
                $this->bot->getConnection()->sendData(
                        $beginningMsg . $msg
                );
            }
        }
    }
?>
