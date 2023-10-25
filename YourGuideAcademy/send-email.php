<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phoneNumber = $_POST['phoneNumber'];
    $message = $_POST["message"];
    $niveau = $_POST["FormControlSelect1"];


    require "../vendor/autoload.php";

    $mail = new PHPMailer(true);
    try {
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->Username = 'ebuildebuild@gmail.com';
        $mail->Password = 'gdblmghgcdxkynkb';
        $mail->Subject = 'Nouveau contact'; // Set your desired subject here

        $mail->setFrom('ebuildebuild@gmail.com');
        $mail->addAddress("centreyga@gmail.com");

        // Contenu du message personnalisé
        $messageMail = '<html><body>';
        $messageMail .= '<h3>Coordonnées de l\'utilisateur :</h3>';
        $messageMail .= '<p>Nom : ' . $name . '</p>';
        $messageMail .= '<p>Email : ' . $email . '</p>';
        $messageMail .= '<p>niveau d\'études : ' . $niveau . '</p>';

        $messageMail .= '<p>Téléphone : ' . $phoneNumber . '</p>';
        $messageMail .= '<p>Message : ' . $message . '</p>';

        $messageMail .= '</body></html>';
        $mail->Body = $messageMail;
        $mail->isHTML(true);

        if ($mail->send()) {
            $response = array("success" => true, "message" => "Email envoyé avec succès !");
        } else {
            $response = array("success" => false, "message" => "L'email n'a pas pu être envoyé. Erreur : " . $mail->ErrorInfo);
        }
    } catch (Exception $e) {
        $response = array("success" => false, "message" => "L'email n'a pas pu être envoyé. Erreur : " . $e->getMessage());
    }
    header("Content-Type: application/json");
    echo json_encode($response);
} else {
    // Si aucune donnée POST n'a été soumise, renvoyez une réponse JSON d'erreur
    $response = array("success" => false, "message" => "Aucune donnée soumise.");
    header("Content-Type: application/json");
    echo json_encode($response);
}
