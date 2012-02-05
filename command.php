<?php include_once('header.php'); ?>
<div class="span3">
    <?php $_GET['page'] = 'command'; include_once('sidebar.php'); ?>
</div>
<div class="well span9">
    <h1>Commands</h1>    
        <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Usage</th>
            <th>Permission</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr id="space">
            <td>1</td>
            <td>Say</td>
            <td>[#channel] [message], [username] [message]</td>
            <td>
                <div class="btn-group">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">Choose...<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Guest</a></li>
                    <li><a href="#">User</a></li>
                    <li><a href="#">Moderator</a></li>
                    <li><a href="#">Administrator</a></li>
                </ul>
                </div>
            </td>
            <td>
                <div class="btn-group">
                    <a class="btn" href="#"><i class="icon-trash"></i></a>
                </div>
            </td>
          </tr>
        </tbody>
      </table>
    <h1>Get Commands</h1>  
    <p>
        To add to the list of available commands simply place the CommandName.php file
        in your Classes/Command folder. Those commands with automatically show up here, 
        were you can edit their permissions and delete them. You may find additional 
        commands here: <a href="http://wildphp.com">WildPHP Commands</a>.
    </p>
</div>
<?php include_once('footer.php'); ?>