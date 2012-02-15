<?php 
// Include Header
include_once('view/template/header.php');

// Set Pages
if( !isset($_GET['page']) ) { $page = 'index'; }
else { $page = $_GET['page']; }

// Include Sidebar
include_once('view/template/sidebar.php');

// Get Page
include_once('view/pages/'.$page.'.php'); 

// Include Footer
include_once('view/template/footer.php'); 
?>