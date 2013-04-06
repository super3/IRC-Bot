# WildBot - IRC Bot
A IRC Bot built in PHP (using sockets) with OOP. Designed to run off a local LAMP, WAMP, or MAMP stack.
Includes a custom [Upstart](http://upstart.ubuntu.com/) script to run as Linux daemon.

Web
-------
* Official Website: [http://wildphp.com](http://wildphp.com), Source Code: [Github](https://github.com/pogosheep/IRC-Bot)
* Major Contributors: [Super3](http://super3.org), [Pogosheep](http://layne-obserdia.de), [Matejvelikonja](http://velikonja.si)

## Features and Functions

### Standard Commands

* !say [#channel] [message] - Says message in the specified IRC channel.
* !say [username] [message] - Says message in the specified IRC user.
* !join [#channel] - Joins the specified channel.
* !part [#channel] - Parts the specified channel.
* !timeout [seconds] - Bot leaves for the specified number of seconds.
* !restart - Quits and restarts the script.
* !quit - Quits and stops the script.
* /msg [botname] !admin [password] - Identify as the admin. 

### Entended Commands

* !ip - Returns IP of a user.
* !weather [location] - Returns weather data for location.
* !poke [#channel] [username] - Pokes the specified IRC user.
* !joke - Returns random joke. Fetched from [ICNDb.com](http://www.icndb.com/).
* !imdb [movie title] - Searches for movie and returns it's information.


### Listeners


* Joins - Greets users when they join the channel.

## Install & Run

### Dependecy

proctitle (optional) - Changes the process title when running as service.

    pecl install proctitle-alpha

### Config

Copy configuration file and customize its content.

    cp config.php config.local.php

Copy Upstart script to folder and make appropriate changes.

    sudo cp bin/wildbot.conf /etc/init/

### Run

Run as PHP

    php wildbot.php

or Upstart service

    start wildbot

Restart

    restart wildbot

Stop

    stop wildbot

Sample Usage and Output
-------
    <random-user> !say #wildbot hello there
    <wildbot> hello there
    <random-user> !poke #wildbot random-user
    * wildbot pokes random-user