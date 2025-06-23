<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM psicologos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $psicologo = $result->fetch_assoc();

    if (!$psicologo) {
        echo "Psicólogo não encontrado.";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $crp = $_POST['crp'];
    $abordagem = $_POST['abordagem'];
    $publico = $_POST['publico'];
    $descricao = $_POST['descricao'];
    $especialidades = $_POST['especialidades'];

    $especialidades_json = json_encode(explode(',', $especialidades));

    $stmt = $conn->prepare("UPDATE psicologos SET nome=?, crp=?, abordagem=?, publico=?, descricao=?, especialidades=? WHERE id=?");
    $stmt->bind_param("ssssssi", $nome, $crp, $abordagem, $publico, $descricao, $especialidades_json, $id);

    if ($stmt->execute()) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Erro ao atualizar os dados.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Psicólogo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Editar Psicólogo</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $psicologo['id'] ?>">
        <label>Nome:</label>
        <input type="text" name="nome" value="<?= $psicologo['nome'] ?>" required>

        <label>CRP:</label>
        <input type="text" name="crp" value="<?= $psicologo['crp'] ?>" required>

        <label>Abordagem:</label>
        <input type="text" name="abordagem" value="<?= $psicologo['abordagem'] ?>" required>

        <label>Público:</label>
        <input type="text" name="publico" value="<?= $psicologo['publico'] ?>" required>

        <label>Descrição:</label>
        <textarea name="descricao" required><?= $psicologo['descricao'] ?></textarea>

        <label>Especialidades (separadas por vírgula):</label>
        <input type="text" name="especialidades" value="<?= implode(',', json_decode($psicologo['especialidades'], true)) ?>" required>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
