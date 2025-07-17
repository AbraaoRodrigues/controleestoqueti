<?php
include '../includes/header.php';
include '../verifica_login.php';
include '../conexao.php';

// Consulta categorias, fornecedores, unidades de medida
$categorias = $conn->query("SELECT id, nome FROM categorias ORDER BY nome");
$fornecedores = $conn->query("SELECT id, nome FROM fornecedores ORDER BY nome");
$unidades = $conn->query("SELECT id, nome FROM unidades_medida ORDER BY nome");
?>

<div class="container mt-4">
  <h3>Cadastrar Novo Item</h3>
  <form action="salvar.php" method="POST">
    <div class="row">
      <div class="col-md-4 mb-3">
        <label>Código do Item</label>
        <input type="text" name="codigo_item" class="form-control" required>
      </div>
      <div class="col-md-8 mb-3">
        <label>Nome do Item</label>
        <input type="text" name="nome" class="form-control" required>
      </div>
    </div>
    <div class="mb-3">
      <label>Descrição</label>
      <textarea name="descricao" class="form-control"></textarea>
    </div>
    <div class="row">
      <div class="col-md-4 mb-3">
        <label>Categoria</label>
        <select name="categoria_id" class="form-select">
          <option value="">Selecione</option>
          <?php while($cat = $categorias->fetch_assoc()): ?>
          <option value="<?= $cat['id'] ?>"><?= $cat['nome'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-4 mb-3">
        <label>Marca/Modelo</label>
        <input type="text" name="marca_modelo" class="form-control">
      </div>
      <div class="col-md-4 mb-3">
        <label>Unidade de Medida</label>
        <select name="unidade_medida_id" class="form-select">
          <option value="">Selecione</option>
          <?php while($um = $unidades->fetch_assoc()): ?>
          <option value="<?= $um['id'] ?>"><?= $um['nome'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
    </div>
    <div class="mb-3">
      <label>Fornecedor Habitual</label>
      <select name="fornecedor_id" class="form-select">
        <option value="">Selecione</option>
        <?php while($f = $fornecedores->fetch_assoc()): ?>
        <option value="<?= $f['id'] ?>"><?= $f['nome'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Especificações Técnicas</label>
      <textarea name="especificacoes" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Salvar</button>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
