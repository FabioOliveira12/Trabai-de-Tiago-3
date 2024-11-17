<?php
$host = 'localhost';
$dbname = 'loja';  // Nome do banco de dados
$username = 'root'; // Seu usuário do MySQL
$password = '';     // Sua senha do MySQL

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    exit();
}
?>
