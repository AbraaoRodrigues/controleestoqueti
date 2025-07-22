<?php
include '../includes/header.php';
include '../includes/init.php';

$itens = $conn->query("SELECT id, nome FROM itens ORDER BY nome");
$secretarias = $conn->query("SELECT id, nome FROM secretarias ORDER BY nome");
?>

<h3>Registrar Saída</h3>
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
      <label>Data da Saída</label>
      <input type="date" name="data_saida" class="form-control" value="<?= date('Y-m-d') ?>">
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-6">
      <label>Secretaria de Destino</label>
      <select name="destino_setor_id" class="form-select">
        <option value="">Selecione</option>
        <?php while ($s = $secretarias->fetch_assoc()): ?>
          <option value="<?= $s['id'] ?>"><?= $s['nome'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="col-md-6">
      <label>Solicitante</label>
      <input type="text" name="solicitante" class="form-control">
    </div>
  </div>
  <div class="mb-3">
    <label>Motivo / Uso</label>
    <input type="text" name="motivo" class="form-control">
  </div>
  <button type="submit" class="btn btn-danger">Registrar Saída</button>
</form>

<?php include '../includes/footer.php'; ?>
