<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Psicólogo não encontrado.";
    exit;
}

$id = $_GET['id'];

// Consulta ao banco de dados
$stmt = $conn->prepare("SELECT * FROM psicologos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Psicólogo não encontrado.";
    exit;
}

$psicologo = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($psicologo['nome']); ?> - Perfil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <h1><?php echo htmlspecialchars($psicologo['nome']); ?></h1>
        <p><strong>CRP:</strong> <?php echo htmlspecialchars($psicologo['crp']); ?></p>
        <p><strong>Abordagem:</strong> <?php echo htmlspecialchars($psicologo['abordagem']); ?></p>
        <p><strong>Público-alvo:</strong> <?php echo htmlspecialchars($psicologo['publico']); ?></p>
        <p><strong>Descrição:</strong> <?php echo nl2br(htmlspecialchars($psicologo['descricao'])); ?></p>

        <h3>Especialidades</h3>
        <div class="specialties">
            <?php 
            $especialidades = json_decode($psicologo['especialidades'], true);
            if ($especialidades) {
                foreach ($especialidades as $especialidade) {
                    echo "<span class='badge'>$especialidade</span> ";
                }
            }
            ?>
        </div>

        <a href="buscarpsi.php">Voltar à Busca</a>
    </div>

</body>
</html>
