<?php
require "phpmailer/PHPMailerAutoload.php";
require_once('models/Database.php');


function sendMail($dbh, $email, $objet, $body) {  
    try {
        $query = $dbh->prepare("SELECT firstname FROM users WHERE email = :email;");
        $query->execute([
            'email' => $email
        ]);
        $response = $query->fetchAll();
        $username = $response[0]['firstname'];
        
        $mail = new PHPMailer (true);
        $mail = initMailer($mail);
      
        $mail->setFrom('funfair-no-reply@echovps.fr', 'No reply - Fun Fair'); 
        $mail->addAddress($email, $username);

        $mail->isHTML(true);
      
        $mail->Subject = $objet;
      
        $mail->Body = $body;

     
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->send();
    } catch (Exception $e) {
        echo "Mailer Error: " . $e->getMessage();
    }
}


function initMailer($mail) {
    $mail->isSMTP();
    $mail->Host = 'live.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = 'api';
    $mail->Password = '5e1169d1cf99606bbbb2480f5177958f'; 
    $mail->Port = 587;
    return $mail;
}
?>
