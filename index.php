<?php
session_start();
if (isset($_SESSION['usuario'])) {
  header('Location: dashboard.php');
  exit();
}
$msg = isset($_GET['erro']) ? 'Usuário ou senha inválidos!' : '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login - Controle de Estoque TI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f8f9fa;
    }
    .card {
      width: 100%;
      max-width: 400px;
    }
  </style>
</head>
<body>
  <div class="card shadow">
    <div class="card-body">
      <h4 class="card-title text-center mb-4">Controle de Estoque TI</h4>
      <?php if ($msg): ?>
        <div class="alert alert-danger text-center" role="alert"><?= $msg ?></div>
      <?php endif; ?>
      <form method="POST" action="verifica_login.php">
        <div class="mb-3">
          <label for="usuario" class="form-label">Usuário</label>
          <input type="text" name="usuario" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="senha" class="form-label">Senha</label>
          <input type="password" name="senha" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
      </form>
    </div>
  </div>
</body>
</html>
