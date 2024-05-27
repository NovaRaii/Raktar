
<?php
require_once("AbstractPage.php");
require_once("UserDBTools.php");

$userDbTools = new UserDBTools();


if(isset($_GET['token'])) {
    $token = $_GET['token'];
    $user = $userDbTools->getUserByToken($token);
    $registrationDate = new DateTime;  
    $userDbTools->updateUserByToken($registrationDate->format("Y-m-d H:i:s"), $token);
}

if(isset($_POST['btn-login'])) {
    $loginEmail = $_POST['loginEmail'];
    $loginPassword = $_POST['loginPassword'];
    $savedPassword = $userDbTools->getUser($loginEmail);
    $privilege = $userDbTools->getUserPrivilegeByEmail($loginEmail);

    if ($loginPassword == $savedPassword && $privilege == "User")
    {
        header('Location:userindex.php');
    } 
    else 
    {
        echo 'Invalid password.';
    }
    if ($loginPassword == $savedPassword && $privilege == "Admin")
    {
        header('Location:index.php');
    } 
    else 
    {
        echo 'Invalid password.';
    }

}
AbstractPage::showLoginPage();

    
?>