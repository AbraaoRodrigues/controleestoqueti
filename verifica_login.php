<?php
session_start();
include 'conexao.php';

$usuario = $_POST['usuario'];
$senha = hash('sha256', $_POST['senha']);

$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha' AND ativo = 1";
$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $_SESSION['usuario'] = $user['usuario'];
    $_SESSION['usuario_id'] = $user['id'];
    $_SESSION['perfil_id'] = $user['perfil_id'];

    $ip = $_SERVER['REMOTE_ADDR'];
    $ua = $_SERVER['HTTP_USER_AGENT'];
    $conn->query("INSERT INTO logs_sistema (usuario_id, acao, modulo, id_referencia, descricao, ip, user_agent)
                  VALUES ({$user['id']}, 'login', 'autenticacao', {$user['id']}, 'Login no sistema', '$ip', '$ua')");

    header('Location: dashboard.php');
    exit();
} else {
    header('Location: index.php?erro=1');
    exit();
}
?>