<?php
include '../includes/init.php';

$codigo     = $_POST['codigo_item'];
$nome       = $_POST['nome'];
$desc       = $_POST['descricao'];
$categoria  = !empty($_POST['categoria_id']) ? intval($_POST['categoria_id']) : null;
$modelo     = !empty($_POST['modelo_id']) ? intval($_POST['modelo_id']) : null;
$unidade    = !empty($_POST['unidade_medida_id']) ? intval($_POST['unidade_medida_id']) : null;
$fornecedor = !empty($_POST['fornecedor_id']) ? intval($_POST['fornecedor_id']) : null;
$esp        = $_POST['especificacoes'];

// Prepare com tipos corretos
$stmt = $conn->prepare("INSERT INTO itens
  (codigo_item, nome, descricao, categoria_id, modelo_id, unidade_medida_id, fornecedor_id, especificacoes)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssiiiss", $codigo, $nome, $desc, $categoria, $modelo, $unidade, $fornecedor, $esp);
$stmt->execute();

// Log
$uid     = $_SESSION['usuario_id'];
$ip      = $_SERVER['REMOTE_ADDR'];
$ua      = $_SERVER['HTTP_USER_AGENT'];
$last_id = $conn->insert_id;

$conn->query("INSERT INTO logs_sistema
  (usuario_id, acao, modulo, id_referencia, descricao, ip, user_agent)
  VALUES ($uid, 'inseriu', 'item', $last_id, 'Cadastro de novo item: $nome', '$ip', '$ua')");

header('Location: lista.php');
exit();
