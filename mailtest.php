<?php

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'postdisasterreporting@gmail.com';
    $mail->Password   = 'pzsp ibxw ieyf mrzv';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('postdisasterreporting@gmail.com', 'PDR System');
    $mail->addAddress('postdisasterreporting@gmail.com');

    $mail->Subject = 'Test Email';
    $mail->Body    = 'PHPMailer is working!';

    $mail->send();

    echo "Email sent successfully.";

} catch (Exception $e) {
    echo "Error: " . $mail->ErrorInfo;
}