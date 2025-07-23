<?php
include '../includes/init.php';

$nome = trim($_POST['nome'] ?? '');
if ($nome === '') {
  echo json_encode(['erro' => 'Nome não pode ser vazio.']);
  exit;
}

// Verifica duplicidade (case-insensitive)
$stmt = $conn->prepare("SELECT id FROM fornecedores WHERE LOWER(nome) = LOWER(?) LIMIT 1");
$stmt->bind_param("s", $nome);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  echo json_encode(['erro' => 'Fornecedor já cadastrado.']);
  exit;
}

// Insere
$stmt = $conn->prepare("INSERT INTO fornecedores (nome) VALUES (?)");
$stmt->bind_param("s", $nome);
$stmt->execute();

echo json_encode(['id' => $stmt->insert_id, 'nome' => $nome]);
