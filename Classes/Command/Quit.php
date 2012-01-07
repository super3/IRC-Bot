<?php
    /**
     * LICENSE: This source file is subject to Creative Commons Attribution
     * 3.0 License that is available through the world-wide-web at the following URI:
     * http://creativecommons.org/licenses/by/3.0/.  Basically you are free to adapt
     * and use this script commercially/non-commercially. My only requirement is that
     * you keep this header as an attribution to my work. Enjoy!
     *
     * @license http://creativecommons.org/licenses/by/3.0/
     * @link    https://bitbucket.org/pogosheep/irc-bot
     *
     * @package IRCBot
     * @subpackage Command
     * @author Daniel Siepmann <coding.layne@me.com>
     *
     * @encoding UTF-8
     * @created 30.12.2011 20:29:55
     *
     * @filesource
     */

    namespace Command;

    /**
     * Leave IRC altogether. This disconnects from the server.
     *
     * @package IRCBot
     * @subpackage Command
     * @author Daniel Siepmann <daniel.siepmann@me.com>
     */
    class Quit extends \Library\IRCCommand {

        /**
         * Leave IRC altogether. This disconnects from the server.
         */
        public function command() {
            $this->IRCBot->sendDataToServer('QUIT Layne-Obserdia.de IRC Bot Script');
            exit;
        }

    }
?>
