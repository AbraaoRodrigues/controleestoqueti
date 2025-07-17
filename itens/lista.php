<?php
include '../includes/header.php';
include '../verifica_login.php';
include '../conexao.php';

$itens = $conn->query("SELECT i.id, i.codigo_item, i.nome, c.nome AS categoria FROM itens i LEFT JOIN categorias c ON i.categoria_id = c.id ORDER BY i.nome");
?>

<div class="container mt-4">
  <h3>Itens Cadastrados</h3>
  <a href="cadastro.php" class="btn btn-primary mb-3">Novo Item</a>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Código</th>
        <th>Nome</th>
        <th>Categoria</th>
      </tr>
    </thead>
    <tbody>
      <?php while($i = $itens->fetch_assoc()): ?>
      <tr>
        <td><?= $i['codigo_item'] ?></td>
        <td><?= $i['nome'] ?></td>
        <td><?= $i['categoria'] ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
