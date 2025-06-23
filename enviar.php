<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $whatsapp = $_POST["whatsapp"];
    $email = $_POST["email"];
    $crp = $_POST["crp"];
    $especialidades = $_POST["especialidades"];
    $abordagem = $_POST["abordagem"];

    $destinatario = "soupsicologo@psinote.com.br"; // Substitua pelo seu e-mail
    $assunto = "Nova Solicitação de Cadastro - PsiNote";

    $corpo = "Nome: $nome\n";
    $corpo .= "Whatsapp: $whatsapp\n";
    $corpo .= "E-mail: $email\n";
    $corpo .= "CRP: $crp\n";
    $corpo .= "Especialidades: $especialidades\n";
    $corpo .= "Abordagem: $abordagem\n";

    $headers = "From: $email\r\nReply-To: $email\r\n";

    if (mail($destinatario, $assunto, $corpo, $headers)) {
        echo "<script>alert('Solicitação enviada com sucesso!'); window.location.href = 'https://www.psinote.com.br/soupsicologo';</script>";
    } else {
        echo "<script>alert('Erro ao enviar. Tente novamente.'); window.history.back();</script>";
    }
}
?>
