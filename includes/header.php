<?php
session_start();
$usuario_nome = 'Usuário';
$foto = 'avatar.png';
$perfil_id = $_SESSION['perfil_id'] ?? 1;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset='utf-8'>
  <link rel='stylesheet' href='/controle_estoque_ti/assets/css/style.css'>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>

</html>

</head>

<body>
  <div class="d-flex">
    <div class="bg-light border-end p-3" style="min-width: 220px; height: 100vh;">
      <h5>Estoque TI</h5>
      <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link" href="/controle_estoque_ti/dashboard.php">🏠 Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="/controle_estoque_ti/itens/lista.php">📦 Itens</a></li>
        <li class="nav-item"><a class="nav-link" href="/controle_estoque_ti/entradas/registro.php">📥 Entradas</a></li>
        <li class="nav-item"><a class="nav-link" href="/controle_estoque_ti/saidas/registro.php">📤 Saídas</a></li>
        <?php if ($perfil_id == 1): ?>
          <li class="nav-item"><a class="nav-link" href="/controle_estoque_ti/usuarios/lista.php">👤 Usuários</a></li>
          <li class="nav-item"><a class="nav-link" href="/controle_estoque_ti/logs/visualizar.php">📜 Logs</a></li>
        <?php endif; ?>
      </ul>
    </div>
    <div class="flex-grow-1">
      <nav class='navbar navbar-expand-lg navbar-light bg-light px-3'>
        <div class='ms-auto'>
          <div class='dropdown'>
            <a class='d-flex align-items-center text-decoration-none dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
              <img src='/controle_estoque_ti/assets/uploads/usuarios/<?= $foto ?>' class='avatar me-2' style='width:40px;height:40px;border-radius:50%;object-fit:cover;'>
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
      <div class="container-fluid mt-3">
