<?php 
//https://stackoverflow.com/questions/30542095/mailer-error-smtp-connect-failed-in-php-mailer-https-github-com-phpmailer
//REFER above link without fail.

require 'PHPMailer-master/PHPMailerAutoload.php';

$mail = new PHPMailer;
//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.mandrillapp.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'your@username.com';                 // SMTP username
$mail->Password = 'mandrilapp_will_give_you_a_password';                           // SMTP password
$mail->Port = 587;                                    // TCP port to connect to

$mail->From = 'your@email.com';
$mail->FromName = 'Test phpmailer';
$mail->addAddress('who_are_you_sending@to.com');               // Name is optional

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}