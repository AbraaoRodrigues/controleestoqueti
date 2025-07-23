<?php
include '../includes/conexao.php';
$nome = $_POST['nome'];
$conn->query("INSERT INTO categorias (nome) VALUES ('$nome')");
header('Location: cadastro.php');
exit();
?>