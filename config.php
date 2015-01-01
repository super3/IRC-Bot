<?php

return array(
    'server'   => 'irc.freenode.org',
<<<<<<< HEAD
    'port'     => 6667,
    'name'     => 'phpbot',
    'password' => '',
    'nick'     => 'phpbot',
=======
    'serverPassword' => '',
    'port' => 6667,
    'name' => 'phpbot',
    'nick' => 'phpbot',
>>>>>>> 6b287234a76bf24c480b0857d5215c9ed4cb6f3e
    'channels' => array(
        '#phpbot404' => '',
    ),
    'timezone' => 'America/New_York',
    'max_reconnects' => 1,
    'log_file' => 'log.txt',
    'commands' => array(
        'Command\Say' => array(),
        'Command\Weather' => array(
            'yahooKey' => 'a',
        ),
        'Command\Joke'		=> array(),
        'Command\Ip'		=> array(),
        'Command\Imdb'		=> array(),
        'Command\Poke'		=> array(),
        'Command\Join'		=> array(),
        'Command\Part'		=> array(),
        'Command\Timeout'	=> array(),
        'Command\Quit'		=> array(),
        'Command\Restart'	=> array(),
        'Command\Serialise' => array(),
        'Command\Remember'	=> array(),
    ),
    'listeners' => array(
        'Listener\Joins'	=> array(),
        'Listener\Youtube'  => array(),
    ),
);
