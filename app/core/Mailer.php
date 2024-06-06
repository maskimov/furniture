<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;

defined('ROOTPATH') OR exit('Access Denied!');

class Mailer
{
	public function sendMail($email, $subject,$message)
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = MAIL_HOST;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->Port = MAIL_PORT;

        $mail->setFrom(MAIL_SEND_FROM, MAIL_SEND_FROM_NAME);
        $mail->addAddress($email);
        $mail->addReplyTo(MAIL_REPLY_TO, MAIL_REPLY_TO_NAME);
        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = $message;
        
        return $mail->send();
    }
}