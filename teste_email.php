<?php
$to = "soupsicologo@psinote.com.br"; // Substitua pelo seu e-mail
$subject = "Teste de envio de e-mail";
$message = "Se você recebeu este e-mail, o PHP está funcionando corretamente.";
$headers = "From: no-reply@psinote.com.br\r\n";

if (mail($to, $subject, $message, $headers)) {
    echo "E-mail enviado com sucesso!";
} else {
    echo "Falha no envio do e-mail.";
}
?>
