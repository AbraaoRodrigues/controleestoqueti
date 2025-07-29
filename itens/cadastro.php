<?php
include '../includes/header.php';
include '../includes/init.php';

// Consulta categorias, fornecedores, unidades de medida
$categorias = $conn->query("SELECT * FROM categorias ORDER BY nome");
$fornecedores = $conn->query("SELECT id, nome FROM fornecedores ORDER BY nome");
$unidades = $conn->query("SELECT id, nome FROM unidades_medida ORDER BY nome");
$result = $conn->query("SELECT MAX(id) AS max_id FROM itens");
$proximo_id = ($result->fetch_assoc()['max_id'] ?? 0) + 1;
$marcas = $conn->query("SELECT id, nome FROM marcas ORDER BY nome");

?>


<div class="container mt-4">
  <h3>Cadastrar Novo Item</h3>
  <form action="salvar.php" method="POST">
    <div class="row">
      <div class="col-md-4 mb-3">
        <label>Código (automático):</label>
        <input type="text" name="codigo_item" value="<?= $proximo_id ?>" readonly class="form-control">
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
        <div class="input-group">
          <select name="categoria_id" class="form-select" required>
            <option value="">Selecione...</option>
            <?php while ($cat = $categorias->fetch_assoc()): ?>
              <option value="<?= $cat['id'] ?>"><?= $cat['nome'] ?></option>
            <?php endwhile; ?>
          </select>
          <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalCategoria">Cadastrar nova</button>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <label for="marca_id">Marca</label>
        <div class="input-group">
          <select name="marca_id" id="marca_id" class="form-select" required>
            <option value="">Selecione a marca</option>
            <?php $marcas->data_seek(0);
            while ($m = $marcas->fetch_assoc()): ?>
              <option value="<?= $m['id'] ?>"><?= $m['nome'] ?></option>
            <?php endwhile; ?>
          </select>
          <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalMarca">+</button>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <label for="modelo_id">Modelo</label>
        <div class="input-group">
          <select name="modelo_id" id="modelo_id" class="form-select" required>
            <option value="">Selecione a marca primeiro</option>
          </select>
          <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalModelo">+</button>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <label>Unidade de Medida</label>
        <select name="unidade_medida_id" class="form-select">
          <option value="">Selecione</option>
          <?php while ($um = $unidades->fetch_assoc()): ?>
            <option value="<?= $um['id'] ?>"><?= $um['nome'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
    </div>
    <div class="mb-3">
      <label>Fornecedor Habitual</label>
      <div class="input-group">
        <select name="fornecedor_id" id="fornecedor_id" class="form-select">
          <option value="">Selecione</option>
          <?php while ($f = $fornecedores->fetch_assoc()): ?>
            <option value="<?= $f['id'] ?>"><?= $f['nome'] ?></option>
          <?php endwhile; ?>
        </select>
        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalFornecedor">+</button>
      </div>
    </div>

    <div class="mb-3">
      <label>Especificações Técnicas</label>
      <textarea name="especificacoes" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Salvar</button>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Atualiza modelos ao trocar a marca
    document.getElementById('marca_id').addEventListener('change', function() {
      let marcaId = this.value;
      fetch('../itens/get_modelos.php?marca_id=' + marcaId)
        .then(res => res.json())
        .then(data => {
          const select = document.getElementById('modelo_id');
          select.innerHTML = '<option value="">Selecione o modelo</option>';
          data.forEach(modelo => {
            const opt = document.createElement('option');
            opt.value = modelo.id;
            opt.textContent = modelo.nome;
            select.appendChild(opt);
          });
        });
    });

    // Submissão do formulário de nova marca
    document.getElementById('formMarca').addEventListener('submit', function(e) {
      e.preventDefault();
      const form = this;
      const nome = form.nome.value;

      fetch('salvar_marca.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: 'nome=' + encodeURIComponent(nome)
        })
        .then(res => res.json())
        .then(data => {
          if (data.erro) {
            alert(data.erro);
            return;
          }

          const select = document.getElementById('marca_id');
          const opt = document.createElement('option');
          opt.value = data.id;
          opt.textContent = data.nome;
          opt.selected = true;
          select.appendChild(opt);

          // Dispara evento para carregar modelos da nova marca
          select.dispatchEvent(new Event('change'));

          // Fecha o modal
          const modal = bootstrap.Modal.getInstance(document.getElementById('modalMarca'));
          modal.hide();
          form.reset();
        });
    });

    // Submissão do formulário de novo modelo
    document.getElementById('formModelo').addEventListener('submit', function(e) {
      e.preventDefault();
      const form = this;
      const marcaId = form.marca_id.value;
      const nome = form.nome.value;

      fetch('salvar_modelo.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: 'marca_id=' + encodeURIComponent(marcaId) + '&nome=' + encodeURIComponent(nome)
        })
        .then(res => res.json())
        .then(data => {
          if (data.erro) {
            alert(data.erro);
            return;
          }

          // Recarrega modelos
          const selectModelo = document.getElementById('modelo_id');
          fetch('../itens/get_modelos.php?marca_id=' + marcaId)
            .then(res => res.json())
            .then(modelos => {
              selectModelo.innerHTML = '<option value="">Selecione o modelo</option>';
              modelos.forEach(modelo => {
                const opt = document.createElement('option');
                opt.value = modelo.id;
                opt.textContent = modelo.nome;
                selectModelo.appendChild(opt);
              });

              // Seleciona o recém-cadastrado
              const novo = modelos.find(m => m.id == data.id);
              if (novo) {
                selectModelo.value = novo.id;
              }
            });

          const modal = bootstrap.Modal.getInstance(document.getElementById('modalModelo'));
          modal.hide();
          form.reset();
        });
    });

    // Submissão do formulário de novo fornecedor
    const formFornecedor = document.getElementById('formFornecedor');
    if (formFornecedor) {
      formFornecedor.addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const nome = form.nome.value;

        fetch('salvar_fornecedor.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'nome=' + encodeURIComponent(nome)
          })
          .then(res => res.json())
          .then(data => {
            if (data.erro) {
              alert(data.erro);
              return;
            }

            const select = document.getElementById('fornecedor_id');
            const opt = document.createElement('option');
            opt.value = data.id;
            opt.textContent = data.nome;
            opt.selected = true;
            select.appendChild(opt);

            const modal = bootstrap.Modal.getInstance(document.getElementById('modalFornecedor'));
            modal.hide();
            form.reset();
          });
      });
    }
  });
</script>

<?php include 'modais_marcas_modelos.php'; ?>
<?php include 'categorias_modal.php'; ?>
<?php include '../includes/footer.php'; ?>
<?php include 'fornecedores_modal.php'; ?>
