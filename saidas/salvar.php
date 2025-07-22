<?php
include '../verifica_login.php';
include '../conexao.php';

$item_id = $_POST['item_id'];
$quantidade = $_POST['quantidade'];
$data = $_POST['data_saida'];
$setor = $_POST['destino_setor_id'] ?: 'NULL';
$solicitante = $_POST['solicitante'];
$motivo = $_POST['motivo'];
$usuario_id = $_SESSION['usuario_id'];

$conn->query("INSERT INTO saidas (item_id, data_saida, destino_setor_id, solicitante, quantidade, motivo, responsavel_id) 
VALUES ($item_id, '$data', $setor, '$solicitante', $quantidade, '$motivo', $usuario_id)");

$conn->query("INSERT INTO logs_sistema (usuario_id, acao, modulo, id_referencia, descricao, ip, user_agent)
VALUES ($usuario_id, 'saida', 'saidas', LAST_INSERT_ID(), 'Saída de $quantidade unidades do item ID $item_id', '{$_SERVER['REMOTE_ADDR']}', '{$_SERVER['HTTP_USER_AGENT']}')");

header('Location: registro.php');
?>