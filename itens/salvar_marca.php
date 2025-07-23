<?php
include '../includes/init.php';

$nome = trim($_POST['nome']);
if ($nome === '') exit;

// Verifica duplicidade (case-insensitive)
$stmt = $conn->prepare("SELECT id FROM marcas WHERE LOWER(nome) = LOWER(?)");
$stmt->bind_param("s", $nome);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  // Já existe — retorna erro
  echo json_encode(['erro' => 'Marca já cadastrada']);
  exit;
}

// Insere
$stmt = $conn->prepare("INSERT INTO marcas (nome) VALUES (?)");
$stmt->bind_param("s", $nome);
$stmt->execute();

echo json_encode(['id' => $stmt->insert_id, 'nome' => $nome]);
