
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        # CORRECÇÃO: Substitua este email pelo email do destinatário
        $mail_to = "herbertjohn@live.com";
        
        

        # Dados do Remetente
        $subject = trim($_POST["subject"]);
        $name = str_replace(array("\r","\n"),array(" "," ") , 
        strip_tags(trim($_POST["name"])));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST["phone"]);
        $message = trim($_POST["message"]);

        if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($phone) OR empty($subject) OR empty($message)) {
            # Defina um código de resposta 400 (solicitação incorreta) e saia.
            http_response_code(400);
            echo "Por favor, preencha o formulário e tente novamente.";
            exit;
        }

        # Conteúdo do Correio
        $content = "Name: $name\n";
        $content .= "Email: $email\n\n";
        $content .= "Phone: $phone\n";
        $content .= "Message:\n$message\n";

        # cabeçalhos de email.
        $headers  = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
        $headers .= "From: ". $email. "\r\n";
        $headers .= "Reply-To: ". $mail_to. "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        $headers .= "X-Priority: 1" . "\r\n"; 

        # Envie o email.
        $success = mail($mail_to, $subject, $content, $headers);
        if ($success) {
            # Defina um código de resposta 200 (ok).
            http_response_code(200);
            echo "Obrigado! Sua mensagem foi enviada.";
        } else {
            # Defina um código de resposta 500 (erro interno do servidor).
            http_response_code(500);
            echo "Opa! Ocorreu um erro. Não foi possível enviar sua mensagem.";
        }

        } else {
            # Não é uma solicitação POST, defina um código de resposta 403 (proibido).
            http_response_code(403);
            echo "Ocorreu um problema com o seu envio, tente novamente.";
        }
?>
