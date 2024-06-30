<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Verifica se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $jsonData = file_get_contents('php://input');

    // Coverte JSON para um array PHP
    $data = json_decode($jsonData, true);

    // Verifica se os campos obrigatórios foram recebidos
    if ($data !== null) {
 
        $name = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $message = filter_var($data['message'], FILTER_SANITIZE_STRING);

        // Cria uma instância do PHPMailer
        $mail = new PHPMailer;

        // Configuração do servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.titan.email';
        $mail->SMTPAuth = true;
        $mail->Username = 'contato@tectubodesentupidora.com.br';
        $mail->Password = 'Ala01nov@51';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Configurações do e-mail
        $mail->setFrom('contato@tectubodesentupidora.com.br', 'Formulário');
        $mail->addAddress('contato@tectubodesentupidora.com.br'); // Nome do destinatário é opcional
        $mail->addReplyTo($email, $name); // Adiciona o endereço de e-mail do remetente como o endereço de resposta
        $mail->isHTML(true);

        
        // Definir a codificação como UTF-8
        $mail->CharSet = 'UTF-8';

        // Assunto e corpo do e-mail
        $mail->Subject = 'Nova mensagem do formulário de contato';
        $mail->Body = "Nome: $name <br> E-mail: $email <br> Mensagem: $message";

        // Envia o e-mail
        if(!$mail->send()) {
            // Se houver um erro no envio do e-mail, exibe uma mensagem de erro
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo . 'hah';
        } else {
            // Se o e-mail for enviado com sucesso, exibe uma mensagem de sucesso
            echo 'Message has been sent';
        }
    } else {

        echo 'Erro ao decodificar JSON';
    }
} else {
    // Se o método de requisição não for POST, exibe uma mensagem de erro
    echo 'Invalid request';
}
?>
