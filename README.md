# PHP IRC-BOT (WildPHP)
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

### Entended Commands

* !ip - Returns IP of a user.
* !weather [location] - Returns weather data for location.
* !poke [#channel] [username] - Pokes the specified IRC user.
* !joke - Returns random joke. Fetched from [ICNDb.com](http://www.icndb.com/).
* !imdb [movie title] - Searches for movie and returns it's information.
* 

### Command Arguments
A change has been made as of 5/1/2015 which means that `-1` for `$numberOfArguments` will now not work as it used to. `-1` will not accept no arguments, only 1+.
Please use `$numberOfArguments = [0, -1];` to emulate the same functionality as before.


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

### Sample Usage and Output

    <random-user> !say #wildphp hello there
    <wildphp-bot> hello there
    <random-user> !poke #wildphp random-user
    * wildphp-bot pokes random-user
    
### Upcoming Features

* Hostname Authentication
* Custom Quit Messages
* Custom Prefixes
* More Plugins
* Bug Fixes
* Extended Documentation
