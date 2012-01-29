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
     * @author Super3 <admin@wildphp.org>
     */

    // Configure PHP
    set_time_limit( 0 );
    ini_set( 'display_errors', 'on' );

    // Make autoload working
    require 'Classes/Autoloader.php';
    spl_autoload_register( 'Autoloader::load' );

    // Create the bot.
    $bot = new Library\IRCBot();

    // Configure the bot.
    $bot->setServer( 'irc.freenode.org' );
    $bot->setPort( 6667 );
    $bot->setChannel( array('#wildphp') );
    $bot->setName( 'wildbotz' );
    $bot->setNick( 'wildbotz' );
    $bot->setMaxReconnects( 1 );
    $bot->setLogFile( 'C:\\Users\\Super3\\Code\\IRC-Bot\\log\\test-' );

    // Add commands to the bot.
    $bot->addCommand( new Command\Say );
    $bot->addCommand( new Command\Poke );
    $bot->addCommand( new Command\Join );
    $bot->addCommand( new Command\Part );
    $bot->addCommand( new Command\Timeout );
    $bot->addCommand( new Command\Quit );
    $bot->addCommand( new Command\Restart );
    $bot->addCommand( new Command\Reboot );

    // Connect to the server.
    $bot->connectToServer();

    // Nothing more possible, the bot runs until script ends.
?>