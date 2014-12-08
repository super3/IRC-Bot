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
     * @license http://creativecommons.org/licenses/by/3.0/
     *
     * @package IRCBot
     * @author Super3 <admin@wildphp.org>
     * @author Matej Velikonja <matej@velikonja.si>
     */

    define('ROOT_DIR', __DIR__);

    // Configure PHP
    //ini_set( 'display_errors', 'on' );

    // Make autoload working
    require 'Classes/Autoloader.php';

    if (file_exists(ROOT_DIR . '/config.local.php')) {
        $config = include_once(ROOT_DIR . '/config.local.php');
    } else {
        $config = include_once(ROOT_DIR . '/config.php');
    }

    if (empty(ini_get('date.timezone'))) {
        if (empty($config['timezone']))
            $config['timezone'] = 'UTC';

        date_default_timezone_set($config['timezone']);
    }

    spl_autoload_register( 'Autoloader::load' );

    // Create the bot.
    $bot = new Library\IRC\Bot();

    // Configure the bot.
    $bot->setServer( $config['server'] );
    $bot->setPort( $config['port'] );
    $bot->setChannel( $config['channels'] );
    $bot->setName( $config['name'] );
    $bot->setNick( $config['nick']);
    $bot->setMaxReconnects( $config['max_reconnects'] );
    $bot->setLogFile( $config['log_file'] );

    // Add commands to the bot.
    foreach ($config['commands'] as $commandName => $args) {
        $reflector = new ReflectionClass($commandName);

        $command = $reflector->newInstanceArgs($args);

        $bot->addCommand($command);
    }

    foreach ($config['listeners'] as $listenerName => $args) {
        $reflector = new ReflectionClass($listenerName);

        $listener = $reflector->newInstanceArgs($args);

        $bot->addListener($listener);
    }


    if (function_exists('setproctitle')) {
        $title = basename(__FILE__, '.php') . ' - ' . $config['nick'];
        setproctitle($title);
    }


    // Connect to the server.
    $bot->connectToServer();

    // Nothing more possible, the bot runs until script ends.
