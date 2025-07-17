<?php
include '../includes/header.php';
include '../verifica_login.php';
?>

<div class="container mt-4">
  <h3>Meu Perfil</h3>
  <form action="atualiza_perfil.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Nome</label>
      <input type="text" name="nome" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Nova Senha</label>
      <input type="password" name="senha" class="form-control">
    </div>
    <div class="mb-3">
      <label>Imagem de Perfil</label>
      <input type="file" name="foto" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
