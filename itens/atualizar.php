<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

include '../includes/init.php';

$id = intval($_POST['id'] ?? 0);
$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$especificacoes = trim($_POST['especificacoes'] ?? '');

if (!$id || !$nome) {
  echo json_encode(['erro' => 'ID ou nome ausente.']);
  exit;
}

$stmt = $conn->prepare("UPDATE itens SET nome=?, descricao=?, especificacoes=? WHERE id=?");
$stmt->bind_param('sssi', $nome, $descricao, $especificacoes, $id);

if ($stmt->execute()) {
  registrar_log("Atualizou item #$id ($nome)");
  echo json_encode(['sucesso' => true]);
} else {
  echo json_encode(['erro' => 'Erro ao atualizar o item.']);
}
