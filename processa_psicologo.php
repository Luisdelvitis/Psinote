<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $crp = $_POST['crp'];
    $abordagem = $_POST['abordagem'];
    $publico = $_POST['publico'];
    $descricao = $_POST['descricao'];
    $especialidades = $_POST['especialidades'];

    // Converte especialidades para JSON
    $especialidades_json = json_encode(explode(',', $especialidades));

    $stmt = $conn->prepare("INSERT INTO psicologos (nome, crp, abordagem, publico, descricao, especialidades) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nome, $crp, $abordagem, $publico, $descricao, $especialidades_json);

    if ($stmt->execute()) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Erro ao adicionar psicólogo.";
    }
}
?>
