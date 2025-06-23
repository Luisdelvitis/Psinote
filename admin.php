<?php
include 'db.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Verifica se um psicólogo foi excluído
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM psicologos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Busca todos os psicólogos
$result = $conn->query("SELECT * FROM psicologos");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <h1>Painel Administrativo</h1>

        <h2>Adicionar Psicólogo</h2>
        <form action="processa_psicologo.php" method="post">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="text" name="crp" placeholder="CRP" required>
            <input type="text" name="abordagem" placeholder="Abordagem" required>
            <input type="text" name="publico" placeholder="Público-alvo" required>
            <textarea name="descricao" placeholder="Descrição" required></textarea>
            <input type="text" name="especialidades" placeholder="Especialidades (separadas por vírgula)" required>
            <button type="submit">Adicionar</button>
        </form>

        <h2>Psicólogos Cadastrados</h2>
        <table>
            <tr>
                <th>Nome</th>
                <th>CRP</th>
                <th>Abordagem</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nome']); ?></td>
                    <td><?php echo htmlspecialchars($row['crp']); ?></td>
                    <td><?php echo htmlspecialchars($row['abordagem']); ?></td>
                    <td>
                        <a href="editar_psicologo.php?id=<?php echo $row['id']; ?>">Editar</a>
                        <a href="admin.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>
</html>
