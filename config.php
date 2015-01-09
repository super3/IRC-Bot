<?php
return array(
    'server'   => 'irc.freenode.org',
    'port'     => 6667,
    'name'     => 'phpbot',
    'password' => '',
    'nick'     => 'phpbot',
    'channels' => array(
        '#wildphp',
    ),
    'timezone' => 'America/New_York',
    'max_reconnects' => 1,
    'prefix'         => '!',
    'log' => array(
        'file'       => 'log', // No file extension!
        'dir'        => ROOT_DIR . '/Logs',

        // Set this if you want only output from specific channel(s) to show up.
        // This will not log any other output, so this is not useful for debugging.
        // This is particularly useful if you use public logs.
        // Can contain multiple channels.
        'filter'     => array('#NanoPlayground'),
    ),
    'commands'       => array(
        'Command\Say'     => array(),
        'Command\Weather' => array(
            'yahooKey' => 'a',
        ),
        'Command\Joke'    => array(),
        'Command\Ip'      => array(),
        'Command\Imdb'    => array(),
        'Command\Poke'    => array(),
        'Command\Topic'   => array(),
        'Command\Join'    => array(),
        'Command\Part'    => array(),
        'Command\Timeout' => array(),
        'Command\Quit'    => array(),
        'Command\Restart' => array(),
        'Command\Help'    => array(),
    ),
    'listeners' => array(
        'Listener\Joins' => array(),
    ),
    'hosts' => array(
        'Add trusted hosts in here. Example: example@example.com if no ident server ~example@example.com',
    ),
);
