<?php
 use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';



    session_start();
	include("../settings/connect_datebase.php");
	
	$login = $_POST['login'];
	

    $query_user = $mysqli->query("SELECT * FROM `users` WHERE `login`='".$mysqli->real_escape_string($login)."'");
$user = $query_user->fetch_assoc();

if (!$user) {
    die("Пользователь не найден");
}

$email = $user['email'];




$code = rand(100000, 999999); // Код подтверждения
$_SESSION['code'] = $code;

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'alexeigyll@gmail.com'; // Ваш Gmail
    $mail->Password = 'ukbw mafi wrfh eedr'; // Пароль приложения
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('alexeigyll@gmail.com', 'Your App');
    $mail->addAddress($email); // Получатель
    $mail->isHTML(true);
    $mail->Subject = 'Код подтверждения';
    $mail->Body = "Ваш код: <strong>$code</strong>";

    $mail->send();
    echo 'Код отправлен';
} catch (Exception $e) {
    echo "Ошибка: {$mail->ErrorInfo}";
}

?>