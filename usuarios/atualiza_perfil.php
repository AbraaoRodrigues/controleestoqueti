<?php
include '../conexao.php';
include '../verifica_login.php';

session_start();
$id = $_SESSION['usuario_id'];
$nome = $_POST['nome'];
$senha = !empty($_POST['senha']) ? hash('sha256', $_POST['senha']) : null;
$foto = null;

if (!empty($_FILES['foto']['name'])) {
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $foto = 'usuario_' . $id . '.' . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/uploads/usuarios/' . $foto);
    $conn->query("UPDATE usuarios SET foto='$foto' WHERE id=$id");
}

if ($senha) {
    $conn->query("UPDATE usuarios SET nome='$nome', senha='$senha' WHERE id=$id");
} else {
    $conn->query("UPDATE usuarios SET nome='$nome' WHERE id=$id");
}

// Log da ação
$ip = $_SERVER['REMOTE_ADDR'];
$ua = $_SERVER['HTTP_USER_AGENT'];
$desc = "Atualizou perfil (nome" . ($senha ? ", senha" : "") . ($foto ? ", imagem" : "") . ")";
$conn->query("INSERT INTO logs_sistema (usuario_id, acao, modulo, id_referencia, descricao, ip, user_agent)
VALUES ($id, 'atualizou', 'perfil', $id, '$desc', '$ip', '$ua')");

header('Location: perfil.php');
exit();
?>