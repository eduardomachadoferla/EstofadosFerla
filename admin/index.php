<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/db.php';
exigir_login();

$stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

function nomeCategoria($categoria) {
    $mapa = [
        'sofas' => 'Sofás',
        'sofás' => 'Sofás',
        'poltronas' => 'Poltronas',
        'cadeiras' => 'Cadeiras',
        'cabeceiras' => 'Cabeceiras',
    ];

    $chave = mb_strtolower(trim($categoria), 'UTF-8');
    return $mapa[$chave] ?? $categoria;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Ferla</title>
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
          <a href="#" class="active">Dashboard</a>
          <a href="#cadastro">Cadastrar Produto</a>
          <a href="#lista">Produtos Cadastrados</a>
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
        <h1>Gerenciar Produtos</h1>
      </header>

      <section class="admin-stats">
        <div class="stat-card">
          <span>Total de produtos</span>
          <strong><?= count($produtos) ?></strong>
        </div>

        <div class="stat-card">
          <span>Último cadastro</span>
          <strong><?= !empty($produtos) ? htmlspecialchars($produtos[0]['nome']) : 'Nenhum produto' ?></strong>
        </div>
      </section>

      <section class="admin-panel" id="cadastro">
        <div class="admin-panel-header">
          <h2>Cadastrar produto</h2>
        
        </div>

        <form class="admin-form-grid" method="post" action="salvar_produto.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="categoria">Categoria</label>
            <select id="categoria" name="categoria" required>
              <option value="">Selecione uma categoria</option>
              <option value="sofas">Sofás</option>
              <option value="poltronas">Poltronas</option>
              <option value="cadeiras">Cadeiras</option>
              <option value="cabeceiras">Cabeceiras</option>
            </select>
          </div>

          <div class="form-group">
            <label for="nome">Nome do produto</label>
            <input type="text" id="nome" name="nome" placeholder="Ex: Sofá Elegance 3 Lugares" required>
          </div>

          <div class="form-group full">
            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" placeholder="Descreva o produto..." required></textarea>
          </div>

          <div class="form-group">
            <label for="preco">Preço</label>
            <input type="text" id="preco" name="preco" placeholder="Ex: R$ 3.299,90" required>
          </div>

          <div class="form-group">
            <label for="imagem">Imagem do produto</label>
            <input type="file" id="imagem" name="imagem" accept="image/*" required>
          </div>

          <div class="form-actions full">
            <button type="submit" class="admin-btn-primary">Salvar produto</button>
          </div>
        </form>
      </section>

      <section class="admin-panel" id="lista">
        <div class="admin-panel-header">
          <h2>Produtos cadastrados</h2>
          <p>Veja abaixo os itens cadastrados no sistema.</p>
        </div>

        <div class="admin-products-grid">
          <?php if (!empty($produtos)): ?>
            <?php foreach ($produtos as $produto): ?>
              <article class="admin-product-card">
                <div class="admin-product-image">
                  <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                </div>
<div class="admin-product-content">
  <span class="admin-tag"><?= htmlspecialchars(nomeCategoria($produto['categoria'])) ?></span>
  <h3><?= htmlspecialchars($produto['nome']) ?></h3>
  <p class="admin-price"><?= htmlspecialchars($produto['preco']) ?></p>
   <p style="line-height:1.5; height:3em; overflow:hidden; margin:0;">
  <?= htmlspecialchars($produto['descricao']) ?>
</p>

   <div class="admin-actions">
  <a class="admin-btn-edit" href="editar_produto.php?id=<?= $produto['id'] ?>">Editar</a>

  <a
    class="admin-btn-delete"
    href="excluir_produto.php?id=<?= $produto['id'] ?>"
    onclick="return confirm('Tem certeza que deseja excluir este produto?');"
  >
    Excluir
  </a>
</div>
</div>
              </article>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="admin-empty">
              <p>Nenhum produto cadastrado ainda.</p>
            </div>
          <?php endif; ?>
        </div>
      </section>
    </main>
  </div>

</body>
</html>