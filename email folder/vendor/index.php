<?php
require 'autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 
    $mail->isSMTP();                                      
    $mail->Host       = 'smtp.gmail.com';               
    $mail->SMTPAuth   = true;                             
              
                        
    $mail->SMTPSecure = 'tls';                            
    $mail->Port       = 587;                              

    //Recipients
    
    $mail->addAddress('vinaykumar954258@gmail.com',"vinay");     

    //Content
    $mail->isHTML(true);                                  
    $mail->Subject = 'Greetings';
    $mail->Body    = 'Happy birtyday <b> vinay</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
