
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once("vendor/autoload.php");
require_once("AbstractPage.php");
require_once("UserDBTools.php");

$mail = new PHPMailer(true);
$UsersDbTool = new UserDBTools();

if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if($password != $confirm_password) {
        echo'Nem egyezik a két jelszó';
    }
    else {
    $result = $UsersDbTool->createUsers($username, $email, $password);

    try {

    $mail->isSMTP();                                            
    $mail->Host       = 'localhost';                     
    $mail->SMTPAuth   = false;                                   
    $mail->Port       = 1025;                                   

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress($email, $username);     //Add a recipient
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Email megerosites';
    $mail->Body    = 'Itt a link a megerősítéshez: <a href="http://localhost:8081/Raktar/login.php">Megerosites</a>';
    $mail->AltBody = 'Igen';

    $mail->send();
    echo 'Message has been sent';
    } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    header('Location: login.php');
    exit;
    }   
    }

AbstractPage::showRegistrationPage();

?>