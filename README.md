# PHP BOT 404
A IRC Bot built in PHP (using sockets) with OOP.
Designed to run off a local LAMP, WAMP, or MAMP stack.
With a custom [Upstart](http://upstart.ubuntu.com/) script to run as Linux daemon.

## Web
* [Source] (https://github.com/matejvelikonja/IRC-Bot-404)

## Features and Functions

### Commands

* !weather [location] - Returns weather data for location
* !joke - Returns random joke. Fetched from [ICNDb.com](http://www.icndb.com/).
* !ip - Returns IP of a user.

* !say [#channel] [message] - Says message in the specified IRC channel.
* !say [username] [message] - Says message in the specified IRC user.
* !poke [#channel] [username] - Pokes the specified IRC user.
* !join [#channel] - Joins the specified channel.
* !part [#channel] - Parts the specified channel.
* !timeout [seconds] - Bot leaves for the specified number of seconds.
* !restart - Quits and restarts the script.
* !quit - Quits and stops the script.

### Listeners

Implements listener, that listen to changes in channels.

* Joins - greets users when they join the channel.

## Install

### Config

Copy configuration file and customize its content.

    cp config.php config.local.php

Copy Upstart script to folder and make appropriate changes.

    sudo cp bin/phpbot404.conf /etc/init/

### Run

Run as PHP

    php phpbot404.php

or Upstart service

    start phpbot404

Restart

    restart phpbot404

Stop

    stop phpbot404

## Forked from
    [Pogosheep/IRC-BOT](https://github.com/pogosheep/IRC-Bot)