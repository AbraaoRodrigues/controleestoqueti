<?php
session_start();
include_once 'conexao.php';
$usuario_id = $_SESSION['usuario_id'] ?? null;
$usuario_nome = 'Usuário';
$foto = 'avatar.png';
if ($usuario_id) {
  $res = $conn->query("SELECT nome, foto FROM usuarios WHERE id=$usuario_id");
  if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $usuario_nome = $row['nome'];
    if (!empty($row['foto'])) $foto = $row['foto'];
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <link rel='stylesheet' href='/controle_estoque_ti/assets/css/style.css'>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>

<body>
  <nav class='navbar navbar-expand-lg navbar-light bg-light px-3'>
    <a class='navbar-brand' href='/controle_estoque_ti/dashboard.php'>Estoque TI</a>
    <div class='ms-auto'>
      <div class='dropdown'>
        <a class='d-flex align-items-center text-decoration-none dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
          <img src='/controle_estoque_ti/assets/uploads/usuarios/<?= $foto ?>' class='avatar me-2'>
          <span><?= $usuario_nome ?></span>
        </a>
        <ul class='dropdown-menu dropdown-menu-end'>
          <li><a class='dropdown-item' href='/controle_estoque_ti/usuarios/perfil.php'>Meu Perfil</a></li>
          <li>
            <hr class='dropdown-divider'>
          </li>
          <li><a class='dropdown-item' href='/controle_estoque_ti/logout.php'>Sair</a></li>
        </ul>
      </div>
    </div>
  </nav>
