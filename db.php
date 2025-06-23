<?php
$host = 'localhost'; // ou o endereço do seu servidor
$username = 'psinot54_psi'; // seu usuário MySQL
$password = 'qwerty9090'; // sua senha MySQL
$dbname = 'psinot54_psicologos'; // nome do banco de dados

// Criando a conexão
$conn = new mysqli($host, $username, $password, $dbname);

// Verificando se houve erro na conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
