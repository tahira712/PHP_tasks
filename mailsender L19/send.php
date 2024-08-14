<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->CharSet = "utf-8"; 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Host = 'smtp.gmail.com'; 
    $mail->Port = 587; 

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    $mail->isHTML(true);

    $mail->Username = 'huseynovatahire2004@gmail.com'; 
    $mail->Password = 'cxam xmbr igrv jthe'; 

    $mail->setFrom('huseynovatahire2004@gmail.com', 'Huseynova Tahire'); 
    $mail->addAddress('tahireh961@gmail.com', 'Huseynova Tahire'); 

    $mail->Subject = 'Test';
    $mail->Body = '<b>Test</b>';

    $mail->send();
    echo 'Message has been sent successfully.';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
