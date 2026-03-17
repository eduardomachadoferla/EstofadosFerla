<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/db.php';
exigir_login();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die('Produto não encontrado.');
}

function selected($valor, $atual) {
    return $valor === $atual ? 'selected' : '';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Produto - Ferla</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/estofadosferla/style.css">
</head>
<body class="admin-body">

  <div class="admin-layout">
    <aside class="admin-sidebar">
      <div>
        <div class="admin-brand">
          <h2>FERLA</h2>
          <span>ESTOFADOS</span>
        </div>

        <nav class="admin-menu">
          <a href="index.php" class="active">Voltar ao Admin</a>
          <a href="/estofadosferla/index.php" target="_blank">Ver Site</a>
        </nav>
      </div>

      <div class="admin-sidebar-footer">
        <a href="logout.php" class="logout-link">Sair</a>
      </div>
    </aside>

    <main class="admin-main">
      <header class="admin-header">
        <p class="admin-subtitle">Painel Administrativo</p>
        <h1>Editar Produto</h1>
      </header>

      <section class="admin-panel">
        <div class="admin-panel-header">
          <h2>Atualizar informações</h2>
          <p>Edite os dados do produto abaixo.</p>
        </div>

        <form class="admin-form-grid" method="post" action="atualizar_produto.php" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= $produto['id'] ?>">
          <input type="hidden" name="imagem_atual" value="<?= htmlspecialchars($produto['imagem']) ?>">

          <div class="form-group">
            <label for="categoria">Categoria</label>
            <select id="categoria" name="categoria" required>
              <option value="sofas" <?= selected('sofas', mb_strtolower($produto['categoria'], 'UTF-8')) ?>>Sofás</option>
              <option value="poltronas" <?= selected('poltronas', mb_strtolower($produto['categoria'], 'UTF-8')) ?>>Poltronas</option>
              <option value="cadeiras" <?= selected('cadeiras', mb_strtolower($produto['categoria'], 'UTF-8')) ?>>Cadeiras</option>
              <option value="cabeceiras" <?= selected('cabeceiras', mb_strtolower($produto['categoria'], 'UTF-8')) ?>>Cabeceiras</option>
            </select>
          </div>

          <div class="form-group">
            <label for="nome">Nome do produto</label>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>
          </div>

          <div class="form-group full">
            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" required><?= htmlspecialchars($produto['descricao']) ?></textarea>
          </div>

          <div class="form-group">
            <label for="preco">Preço</label>
            <input type="text" id="preco" name="preco" value="<?= htmlspecialchars($produto['preco']) ?>" required>
          </div>

          <div class="form-group">
            <label for="imagem">Nova imagem (opcional)</label>
            <input type="file" id="imagem" name="imagem" accept="image/*">
          </div>

          <div class="form-group full">
            <label>Imagem atual</label>
            <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>" style="max-width:220px; border-radius:12px; border:1px solid #ddd;">
          </div>

          <div class="form-actions full" style="gap: 12px; display:flex; flex-wrap:wrap;">
            <button type="submit" class="admin-btn-primary">Salvar alterações</button>
            <a href="index.php" class="admin-btn-cancel">Cancelar</a>
          </div>
        </form>
      </section>
    </main>
  </div>

</body>
</html>