<?php
include '../includes/init.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) {
  echo json_encode(['erro' => 'ID inválido']);
  exit;
}

// Verifica se há vínculos com este item em outras tabelas (exemplo: movimentações)
$verifica = $conn->query("SELECT 1 FROM movimentacoes WHERE item_id = $id LIMIT 1");

if ($verifica && $verifica->num_rows > 0) {
  // Exclusão lógica
  $conn->query("UPDATE itens SET ativo = 0 WHERE id = $id");

  $acao = 'desativou';
  $descricao = 'Desativação lógica do item ID ' . $id;
} else {
  // Exclusão física
  $conn->query("DELETE FROM itens WHERE id = $id");

  $acao = 'excluiu';
  $descricao = 'Exclusão definitiva do item ID ' . $id;
}

// Log da ação
$uid = $_SESSION['usuario_id'] ?? 0;
$ip  = $_SERVER['REMOTE_ADDR'];
$ua  = $_SERVER['HTTP_USER_AGENT'];

$conn->query("INSERT INTO logs_sistema (usuario_id, acao, modulo, id_referencia, descricao, ip, user_agent)
VALUES ($uid, '$acao', 'item', $id, '$descricao', '$ip', '$ua')");

echo json_encode(['sucesso' => true]);
