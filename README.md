IRC-BOT
=============
A basic IRC Bot built in PHP (using sockets) with wonderful OOP. 
Designed to run off a local LAMP, WAMP, or MAMP stack.
The IRC Bot can be run in either a Browser window, or a Commnad Line.

Web
-------
Official Website - http://wildphp.com
Source Code - https://github.com/pogosheep/IRC-Bot

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

Sample Usage and Output
-------
    <random-user> !say #wildphp hello there
    <wildphp-bot> hello there
    <random-user> !poke #wildphp random-user
    * wildphp-bot pokes random-user