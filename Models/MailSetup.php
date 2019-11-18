<?php

/******************************************************************************************************************\
 *File:    MailSetup.php                                                                                           *
 *Project: #ZOMBIES                                                                                                *
 *Date:    November 13th, 2019                                                                                     *
 *Purpose: This is where the mail setup will be done and then required only once in the controller                 *
\******************************************************************************************************************/

//instantiate PHPMailer object
$mail = new PHPMailer(true); //true enables exception handling

//SMTP server settings setup as shown in the library's documentation
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
$mail->isSMTP();                                            // Send using SMTP
$mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
$mail->Username   = 'hashtagzombies.development@gmail.com'; // SMTP username
$mail->Password   = 'zyrhoj-4vuqxi-xYkvuj';                 // SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
$mail->Port       = 587;
