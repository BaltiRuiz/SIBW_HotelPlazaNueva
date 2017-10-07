<?php

    require 'PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP server
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'pakekieresaberesojajasalu2s@gmail.com';                 // SMTP username
    $mail->Password = 'pakekieressabereso';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
    $mail->From = 'pakekieresaberesojajasalu2s@gmail.com';
    $mail->FromName = 'xdxd';
    $mail->addAddress('canavate100@gmail.com', 'xd');     // Add a recipient
    $mail->addAddress($femail, $fnombre);     // Add a recipient
    $mail->Subject = '[Jajakloko] Asunto';
    $mail->Body    = $fmensaje;
    $mail->Send();

?>
