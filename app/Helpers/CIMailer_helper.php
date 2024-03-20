<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// SEND EMAIL FUNCTION USING PHPMAILER LIBARY
if (!function_exists('send_email')) {
  function send_email($mailConfig)
  {
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = 'ahmadsabili0082@gmail.com';
    $mail->Password = 'cvqm wnob umae guwl';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom($mailConfig['mail_from_email'], $mailConfig['mail_from_name']);
    $mail->addAddress($mailConfig['mail_recipient_email'], $mailConfig['mail_recipient_name']);
    $mail->isHTML(true);
    $mail->Subject = $mailConfig['mail_subject'];
    $mail->Body = $mailConfig['mail_body'];
    if ($mail->send()) {
      return true;
    } else {
      return false;
    }
  }
}
