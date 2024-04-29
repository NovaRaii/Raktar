
<?php
require_once("AbstractPage.php");
require_once("UserDBTools.php");

$UsersDbTool = new UserDBTools();

AbstractPage::showLoginPage();
    
?>