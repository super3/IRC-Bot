IRC-BOT
=============
A basic IRC Bot built in PHP (using sockets) with wonderful OOP. 
Designed to run off a local LAMP, WAMP, or MAMP stack.

Web
-------
* [Our Official Website](http://wildphp.com)
* [The Source Code](https://github.com/pogosheep/IRC-Bot)

Collaborators
-------
* [Super3](http://super3.org) - Frontend
* [Pogosheep](https://plus.google.com/108868126361135455230/about)- Backend

Features and Functions
-------
* !say [#channel] [message] - Says message in the specified IRC channel.
* !say [username] [message] - Says message in the specified IRC user.
* !poke [#channel] [username] - Pokes the specified IRC user.
* !join [#channel] - Joins the specified channel.
* !part [#channel] - Parts the specified channel.
* !timeout [seconds] - Bot leaves for the specified number of seconds.
* !restart - Quits and restarts the script.
* !quit - Quits and stops the script. 
    
Install and Run
-------
1. Place the IRC-Bot folder in your server directory or htdocs. 
2. Create or edit a config file with your details 
    (layne_bot.php and wild_bot.php are two working examples).
3. Open that config file in your browser, or a command line.
4. The bot will run as long as the command line or browser is open. 

Sample Usage and Output
-------
    <random-user> !say #wildphp hello there
    <wildphp-bot> hello there
    <random-user> !poke #wildphp random-user
    * wildphp-bot pokes random-user