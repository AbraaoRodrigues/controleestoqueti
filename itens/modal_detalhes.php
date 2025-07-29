<?php
include '../includes/init.php';

$id = intval($_GET['id'] ?? 0);
if (!$id) exit('ID inválido');

$item = $conn->query("SELECT i.*, c.nome AS categoria, m.nome AS modelo, ma.nome AS marca,
       f.nome AS fornecedor, u.nome AS unidade
FROM itens i
LEFT JOIN categorias c ON i.categoria_id = c.id
LEFT JOIN modelos m ON i.modelo_id = m.id
LEFT JOIN marcas ma ON m.marca_id = ma.id  -- Aqui está o vínculo indireto
LEFT JOIN fornecedores f ON i.fornecedor_id = f.id
LEFT JOIN unidades_medida u ON i.unidade_medida_id = u.id
WHERE i.id = $id
")->fetch_assoc();

if (!$item) exit('Item não encontrado.');
?>

<div class="modal-header">
  <h5 class="modal-title">Detalhes do Item #<?= $item['codigo_item'] ?></h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
  <form id="formDetalhes">
    <input type="hidden" name="id" value="<?= $item['id'] ?>">
    <div class="row">
      <div class="col-md-6 mb-3">
        <label>Nome</label>
        <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($item['nome']) ?>" disabled>
      </div>
      <div class="col-md-6 mb-3">
        <label>Categoria</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($item['categoria']) ?>" disabled>
      </div>
    </div>
    <div class="mb-3">
      <label>Descrição</label>
      <textarea name="descricao" class="form-control" disabled><?= htmlspecialchars($item['descricao']) ?></textarea>
    </div>
    <div class="row">
      <div class="col-md-4 mb-3">
        <label>Marca</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($item['marca']) ?>" disabled>
      </div>
      <div class="col-md-4 mb-3">
        <label>Modelo</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($item['modelo']) ?>" disabled>
      </div>
      <div class="col-md-4 mb-3">
        <label>Unidade</label>
        <input type="text" class="form-control" value="<?= htmlspecialchars($item['unidade']) ?>" disabled>
      </div>
    </div>
    <div class="mb-3">
      <label>Fornecedor</label>
      <input type="text" class="form-control" value="<?= htmlspecialchars($item['fornecedor']) ?>" disabled>
    </div>
    <div class="mb-3">
      <label>Especificações Técnicas</label>
      <textarea name="especificacoes" class="form-control" disabled><?= htmlspecialchars($item['especificacoes']) ?></textarea>
    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" id="btnEditar" class="btn btn-primary">Editar</button>
  <button type="button" id="btnCancelar" class="btn btn-secondary" style="display:none;">Cancelar</button>
  <button type="button" id="btnSalvar" class="btn btn-success" style="display:none;">Salvar</button>
  <button type="button" id="btnExcluir" class="btn btn-danger">Excluir</button>
</div>
