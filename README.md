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


### Listeners


* Joins - Greets users when they join the channel.

## Install & Run

### Dependecy

proctitle (optional) - Changes the process title when running as service.

    pecl install proctitle-alpha

### Config

Copy configuration file and customize its content.

    cp config.php config.local.php

#### For Upstart/Ubuntu/Debian users
Copy Upstart script to folder and make appropriate changes.

    sudo cp bin/phpbot404.conf /etc/init/
    
#### For Systemd/Arch
Copy the Systemd script to folder and edit it.

    sudo cp bin/phpbot404.service /etc/systemd/system
You can control the service with systemctl afterwards.

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
    
### Community

IRC: [#phpbot404@freenode.net](http://webchat.freenode.net/?channels=phpbot404)
