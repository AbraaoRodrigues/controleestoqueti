<div class="modal fade" id="modalCategoria" tabindex="-1" aria-labelledby="modalCategoriaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formNovaCategoria" method="POST" action="salvar_categoria.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Cadastrar Nova Categoria</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <label>Nome da Categoria</label>
          <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </form>
  </div>
</div>