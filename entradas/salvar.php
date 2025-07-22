<?php
include '../verifica_login.php';
include '../conexao.php';

$item_id = $_POST['item_id'];
$quantidade = $_POST['quantidade'];
$data = $_POST['data_entrada'];
$origem = $_POST['origem'];
$nota = $_POST['nota_fiscal'];
$proc = $_POST['processo_compra'];
$sec = $_POST['secretaria_id'] ?: 'NULL';
$local = $_POST['local_armazenamento'];
$usuario_id = $_SESSION['usuario_id'];

$conn->query("INSERT INTO entradas (item_id, data_entrada, origem, quantidade, processo_compra, nota_fiscal, responsavel_id) 
VALUES ($item_id, '$data', '$origem', $quantidade, '$proc', '$nota', $usuario_id)");

for ($i = 0; $i < $quantidade; $i++) {
  $conn->query("INSERT INTO estoque_unidades (item_id, data_entrada, secretaria_id, local_armazenamento, situacao, status, data_ultima_movimentacao)
  VALUES ($item_id, '$data', $sec, '$local', 'novo', 'em estoque', NOW())");
}

$conn->query("INSERT INTO logs_sistema (usuario_id, acao, modulo, id_referencia, descricao, ip, user_agent)
VALUES ($usuario_id, 'entrada', 'entradas', LAST_INSERT_ID(), 'Entrada de $quantidade unidades do item ID $item_id', '{$_SERVER['REMOTE_ADDR']}', '{$_SERVER['HTTP_USER_AGENT']}')");

header('Location: registro.php');
?>