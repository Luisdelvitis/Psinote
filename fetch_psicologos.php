<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');
include 'db.php'; // Arquivo de conexão com o banco

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;

$query = "SELECT id, nome, crp, abordagem, publico, valor, imagem, descricao, especialidades FROM psicologos ORDER BY RAND() LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

$psychologists = [];
while ($row = $result->fetch_assoc()) {
    $row['especialidades'] = explode(',', $row['especialidades']); // Transforma a string em array
    $psychologists[] = $row;
}

echo json_encode($psychologists);
$stmt->close();
$conn->close();
?>
