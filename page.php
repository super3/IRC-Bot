<?php include_once('view/template/header.php'); ?>
<div class="span3">
    <?php include_once('view/template/sidebar.php'); ?>
</div>
<?php include_once('view/pages/'.$_GET['page'].'.php'); ?>
<?php include_once('view/template/footer.php'); ?>