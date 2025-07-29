<?php
include '../includes/init.php';
include '../includes/header.php';

$itens = $conn->query("SELECT i.id, i.codigo_item, i.nome, c.nome AS categoria FROM itens i LEFT JOIN categorias c ON i.categoria_id = c.id ORDER BY i.nome");
?>

<div class="container mt-4">
  <h3>Itens Cadastrados</h3>
  <a href="cadastro.php" class="btn btn-primary mb-3">Novo Item</a>
  <!--<table class="table table-striped">-->
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Código</th>
        <th>Nome</th>
        <th>Categoria</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($item = $itens->fetch_assoc()): ?>
        <tr data-id="<?= $item['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalDetalhes" style="cursor: pointer;">
          <td><?= htmlspecialchars($item['codigo_item']) ?></td>
          <td><?= htmlspecialchars($item['nome']) ?></td>
          <td><?= htmlspecialchars($item['categoria']) ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <!-- Modal de Detalhes -->
  <div class="modal fade" id="modalDetalhes" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" id="detalhesConteudo">
        <!-- Conteúdo será carregado via AJAX -->
        <div class="modal-body text-center p-5">
          <div class="spinner-border text-primary" role="status"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function inicializarEventosModal() {
    const editarBtn = document.getElementById('btnEditar');
    const excluirBtn = document.getElementById('btnExcluir');
    const salvarBtn = document.getElementById('btnSalvar');
    const cancelarBtn = document.getElementById('btnCancelar');
    const form = document.getElementById('formDetalhes');

    if (!form) return;

    const inputs = form.querySelectorAll('input, textarea, select');
    let originalData = {};

    inputs.forEach(inp => {
      if (inp.name) {
        originalData[inp.name] = inp.value;
      }
    });

    function toggleEditMode(enable) {
      inputs.forEach(inp => inp.disabled = !enable);
      salvarBtn.style.display = enable ? 'inline-block' : 'none';
      cancelarBtn.style.display = enable ? 'inline-block' : 'none';
      editarBtn.style.display = enable ? 'none' : 'inline-block';
    }

    editarBtn.addEventListener('click', () => toggleEditMode(true));

    cancelarBtn.addEventListener('click', () => {
      inputs.forEach(inp => {
        if (inp.name) {
          inp.value = originalData[inp.name];
          inp.disabled = true;
        }
      });
      toggleEditMode(false);
    });

    salvarBtn.addEventListener('click', () => {
      const formData = new FormData(form);
      fetch('atualizar.php', {
          method: 'POST',
          body: formData
        })
        .then(res => res.json())
        .then(resp => {
          if (resp.sucesso) {
            alert('Atualizado com sucesso!');
            toggleEditMode(false);
            inputs.forEach(inp => {
              if (inp.name) originalData[inp.name] = inp.value;
            });
          } else {
            alert('Erro ao atualizar: ' + (resp.erro || 'erro desconhecido'));
          }
        });
    });

    excluirBtn.addEventListener('click', () => {
      const id = form.querySelector('input[name="id"]').value;
      if (confirm('Tem certeza que deseja excluir este item?')) {
        fetch('excluir.php?id=' + id)
          .then(res => res.json())
          .then(resp => {
            if (resp.sucesso) {
              alert('Item excluído com sucesso!');
              const modal = bootstrap.Modal.getInstance(document.getElementById('modalDetalhes'));
              modal.hide();
              setTimeout(() => location.reload(), 500);
            } else {
              alert('Erro ao excluir: ' + (resp.erro || 'erro desconhecido'));
            }
          });
      }
    });

    toggleEditMode(false);
  }

  document.querySelectorAll('tr[data-id]').forEach(row => {
    row.addEventListener('click', function() {
      const id = this.dataset.id;
      document.getElementById('detalhesConteudo').innerHTML = '<div class="modal-body text-center p-5"><div class="spinner-border text-primary" role="status"></div></div>';
      fetch('modal_detalhes.php?id=' + id)
        .then(res => res.text())
        .then(html => {
          document.getElementById('detalhesConteudo').innerHTML = html;
          inicializarEventosModal(); // 👈 ESSENCIAL!
        });
    });
  });
</script>


<?php include '../includes/footer.php'; ?>
