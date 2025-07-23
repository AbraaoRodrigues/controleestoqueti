<?php
include '../includes/init.php';

$nome = trim($_POST['nome']);
$marca_id = intval($_POST['marca_id']);

if ($nome === '' || $marca_id <= 0) exit;

// Verifica duplicidade
$stmt = $conn->prepare("SELECT id FROM modelos WHERE marca_id = ? AND LOWER(nome) = LOWER(?)");
$stmt->bind_param("is", $marca_id, $nome);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  echo json_encode(['erro' => 'Modelo já cadastrado para esta marca']);
  exit;
}

// Insere
$stmt = $conn->prepare("INSERT INTO modelos (marca_id, nome) VALUES (?, ?)");
$stmt->bind_param("is", $marca_id, $nome);
$stmt->execute();

echo json_encode(['id' => $stmt->insert_id, 'nome' => $nome]);
