<?php
include '../verifica_login.php';
include '../conexao.php';

$codigo = $_POST['codigo_item'];
$nome = $_POST['nome'];
$desc = $_POST['descricao'];
$categoria = $_POST['categoria_id'] ?: 'NULL';
$modelo = $_POST['marca_modelo'];
$unidade = $_POST['unidade_medida_id'] ?: 'NULL';
$fornecedor = $_POST['fornecedor_id'] ?: 'NULL';
$esp = $_POST['especificacoes'];

$stmt = $conn->prepare("INSERT INTO itens 
(codigo_item, nome, descricao, categoria_id, marca_modelo, unidade_medida_id, fornecedor_id, especificacoes) 
VALUES (?, ?, ?, $categoria, ?, $unidade, $fornecedor, ?)");
$stmt->bind_param("ssssss", $codigo, $nome, $desc, $modelo, $esp, $esp);
$stmt->execute();

// registrar log
$uid = $_SESSION['usuario_id'];
$ip = $_SERVER['REMOTE_ADDR'];
$ua = $_SERVER['HTTP_USER_AGENT'];
$conn->query("INSERT INTO logs_sistema (usuario_id, acao, modulo, id_referencia, descricao, ip, user_agent)
VALUES ($uid, 'inseriu', 'item', LAST_INSERT_ID(), 'Cadastro de novo item: $nome', '$ip', '$ua')");

header('Location: lista.php');
exit();
?>