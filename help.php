<?php include_once('header.php'); ?>
<div class="span3">
    <?php $_GET['page'] = 'help'; include_once('sidebar.php'); ?>
</div>
<div class="well span9">
    <h1>Help</h1>    
        <p>This is a basic IRC Bot built in PHP (using sockets) with wonderful OOP. 
        Designed to run off a local LAMP, WAMP, or MAMP stack.</p>
    <h2>Web</h2>
        <ul>
            <li><a href="http://wildphp.com">Our Official Website</a></li>
            <li><a href="https://github.com/pogosheep/IRC-Bot">The Source Code</a></li>
        </ul>
    <h2>Collaborators</h2>
        <ul>
            <li><a href="http://super3.org">Super3</a> - Frontend</li>
            <li><a href="https://plus.google.com/108868126361135455230/about">Pogosheep</a> - Backend</li>
        </ul>            
    <h2>Features and Functions</h2>
        <ul>
            <li>!say [#channel] [message] - Says message in the specified IRC channel.</li>
            <li>!say [username] [message] - Says message in the specified IRC user.</li>
            <li>!poke [#channel] [username] - Pokes the specified IRC user.</li>
            <li>!join [#channel] - Joins the specified channel.</li>
            <li>!part [#channel] - Parts the specified channel.</li>
            <li>!timeout [seconds] - Bot leaves for the specified number of seconds.</li>
            <li>!restart - Quits and restarts the script.</li>
            <li>!quit - Quits and stops the script. </li>
        </ul>
    <h2>Sample Usage and Output</h2>
    <div>
        &lt;random-user&gt; !say #wildphp hello there<br/>
        &lt;wildphp-bot&gt; hello there<br/>
        &lt;random-user&gt; !poke #wildphp random-user<br/>
        * wildphp-bot pokes random-user<br/>
    </div>
</div>
<?php include_once('footer.php'); ?>