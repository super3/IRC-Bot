<?php
return array(
    'server'   => 'irc.freenode.org',
    'serverPassword' => '',
    'port'     => 6667,
    'name'     => 'phpbot',
    'nick'     => 'phpbot',
    'adminPassword' => '',
    'commandPrefix' => '!',
    'channels' => array(
        '#phpbot404' => '',
    ),
    'max_reconnects' => 1,
    'log_file'       => 'log.txt',
    'commands'       => array(
        'Command\Say'     => array(),
        'Command\Weather' => array(
            'yahooKey' => 'ChangeMe',
        ),
        'Command\Joke'    => array(),
        'Command\Ip'      => array(),
        'Command\Yt'      => array(),
        'Command\Imdb'    => array(),
        'Command\Poke'    => array(),
        'Command\Join'    => array(),
        'Command\Part'    => array(),
        'Command\Timeout' => array(),
        'Command\Quit'    => array(),
        'Command\Restart' => array(),
        'Command\Serialise' => array(),
        'Command\Remember'  => array(),
    ),
    'listeners' => array(
        'Listener\Joins' => array(),
    ),
);
