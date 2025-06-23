<?php
include 'db.php';

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
} else {
    echo "Conectado ao banco de dados!";
}
?>
