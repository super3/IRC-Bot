<?php $page = $_GET['page']; ?>
<div class="well" style="padding: 8px 0;">
    <ul class="nav nav-list">
        <li class="nav-header">Main</li>
            <li <?php if($page == 'index') { echo "class=\"active\""; }?>><a href="index.php"><i class="<?php if($page == 'index') { echo "icon-white "; }?>icon-home"></i> Home</a></li>
            <li <?php if($page == 'bot') { echo "class=\"active\""; }?>><a href="page.php?page=bot"><i class="<?php if($page == 'bot') { echo "icon-white "; }?>icon-book"></i> My Bots</a></li>
            <li <?php if($page == 'command') { echo "class=\"active\""; }?>><a href="page.php?page=command"><i class="<?php if($page == 'command') { echo "icon-white "; }?>icon-pencil"></i> Commands</a></li>
        <li class="nav-header">Info</li>
            <li><a href="#"><i class="icon-user"></i> Logs</a></li>
            <li><a href="#"><i class="icon-cog"></i> Settings</a></li>
            <li <?php if($page == 'help') { echo "class=\"active\""; }?>><a href="page.php?page=help"><i class="<?php if($page == 'help') { echo "icon-white "; }?>icon-flag"></i> Help</a></li>
    </ul>
</div>