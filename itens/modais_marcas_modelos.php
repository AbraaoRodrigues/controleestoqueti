<!-- Modal Marca -->
<div class="modal fade" id="modalMarca" tabindex="-1">
  <div class="modal-dialog">
    <form id="formMarca" class="modal-content" method="POST" action="salvar_marca.php">
      <div class="modal-header">
        <h5 class="modal-title">Nova Marca</h5>
      </div>
      <div class="modal-body">
        <input type="text" name="nome" class="form-control" placeholder="Nome da marca" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Modelo -->
<div class="modal fade" id="modalModelo" tabindex="-1">
  <div class="modal-dialog">
    <form id="formModelo" class="modal-content" method="POST" action="salvar_modelo.php">
      <div class="modal-header">
        <h5 class="modal-title">Novo Modelo</h5>
      </div>
      <div class="modal-body">
        <input type="text" name="nome" class="form-control mb-2" placeholder="Nome do modelo" required>
        <select name="marca_id" class="form-select" required>
          <option value="">Selecione a marca</option>
          <?php
          $marcas = $conn->query("SELECT id, nome FROM marcas ORDER BY nome");
          while ($m = $marcas->fetch_assoc()): ?>
            <option value="<?= $m['id'] ?>"><?= $m['nome'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
  </div>
</div>
