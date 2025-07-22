<?php
include '../includes/init.php';
include '../includes/header.php';

$itens = $conn->query("SELECT id, nome FROM itens ORDER BY nome");
$secretarias = $conn->query("SELECT id, nome FROM secretarias ORDER BY nome");
?>

<h3>Registrar Entrada</h3>
<form action="salvar.php" method="POST">
  <div class="row mb-3">
    <div class="col-md-6">
      <label>Item</label>
      <select name="item_id" class="form-select" required>
        <option value="">Selecione</option>
        <?php while ($i = $itens->fetch_assoc()): ?>
          <option value="<?= $i['id'] ?>"><?= $i['nome'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-3">
      <label>Quantidade</label>
      <input type="number" name="quantidade" class="form-control" required>
    </div>
    <div class="col-md-3">
      <label>Data da Entrada</label>
      <input type="date" name="data_entrada" class="form-control" value="<?= date('Y-m-d') ?>">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-6">
      <label>Origem</label>
      <input type="text" name="origem" class="form-control">
    </div>
    <div class="col-md-6">
      <label>Nota Fiscal</label>
      <input type="text" name="nota_fiscal" class="form-control">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-6">
      <label>Processo de Compra</label>
      <input type="text" name="processo_compra" class="form-control">
    </div>
    <div class="col-md-6">
      <label>Secretaria de Destino</label>
      <select name="secretaria_id" class="form-select">
        <option value="">Selecione</option>
        <?php while ($s = $secretarias->fetch_assoc()): ?>
          <option value="<?= $s['id'] ?>"><?= $s['nome'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>
  </div>
  <div class="mb-3">
    <label>Local de Armazenamento</label>
    <input type="text" name="local_armazenamento" class="form-control">
  </div>
  <button type="submit" class="btn btn-success">Salvar</button>
</form>

<?php include '../includes/footer.php'; ?>
