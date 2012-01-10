IRC-BOT
=============
A basic and simple IRC Bot built in PHP (using sockets). 
Designed to run off a local LAMP, WAMP, or MAMP stack.

Features and Functions
-------
* !say #channel Message - Says message in the specified IRC channel.
* !say username Message - Says message in the specified IRC user.
* !poke #channel username - Pokes the specified IRC user.
* !restart - Quits and restarts the script.
* !quit - Quits and stops the script.

Usage and Output
-------
    <random-user> !say #wildphp hello there
    <wildphp-bot> hello there
    <random-user> !poke #wildphp random-user
    * wildphp-bot pokes random-user

General Command Ideas
-------
* timeout - Bot leaves for the specified number of minutes (HTTP refresh).
* stat - Generate some brief stats about the bot.

Fun Command Ideas
-------
* cookie - Gives the specified user a cookie.
* milk - Gives the specified user a glass of milk.
* hug -  Gives the specified a hug.

Bot Option Ideas
-------
* joinMsg - Says this message whenever it joins a channel.
* greetMsg - Says this message (via PM) to each new user to the channel.