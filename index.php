<?php
require_once __DIR__ . '/config/db.php';
$titulo = 'Ferla Estofados';

$busca = trim($_GET['busca'] ?? '');

$sql = "SELECT * FROM produtos";
$params = [];

if (!empty($busca)) {
    $sql .= " WHERE nome LIKE :busca OR descricao LIKE :busca OR categoria LIKE :busca";
    $params[':busca'] = '%' . $busca . '%';
}
if (!empty($categoria)) {
    $sql .= " AND categoria = :categoria";
    $params[':categoria'] = $categoria;
}

$sql .= " ORDER BY id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/includes/header.php';
?>

<link rel="stylesheet" href="/estofadosferla/style.css">

<main>
    <section class="hero" id="inicio">
        <div class="hero-content container">
            <h1>Estofados Ferla</h1>
            <p>Conforto e sofisticação que transformam seu lar</p>
            <a href="#produtos" class="btn">VER PRODUTOS</a>
        </div>
    </section>

    <section class="section" id="produtos">
        <div class="container">
            <div class="section-header">
                <h2>Todos os Produtos</h2>
                <p>Encontre o estofado ideal para seu ambiente</p>
            </div>

            <div class="products-grid">
                <?php if (!empty($produtos)): ?>
                <?php foreach ($produtos as $produto): ?>
                <article class="card">
                    <div class="card-image">
                        <img src="<?= htmlspecialchars($produto['imagem']) ?>"
                            alt="<?= htmlspecialchars($produto['nome']) ?>">
                    </div>

                    <div class="card-body">
                        <span class="tag"><?= htmlspecialchars($produto['categoria']) ?></span>
                        <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                        <p>
                            <?= htmlspecialchars($produto['descricao']) ?>
                        </p>

                        <div class="card-footer">
                            <strong class="price"><?= htmlspecialchars($produto['preco']) ?></strong>
                            <a class="outline-btn" href="/estofadosferla/produto.php?id=<?= $produto['id'] ?>">Saber
                                mais</a>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="no-results">Nenhum produto encontrado para sua pesquisa.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- <section class="categories" id="sobre">
    <div class="container">
      <div class="section-header">
        <h2>Sobre Nós</h2>
        <p>Elegância, conforto e qualidade em cada detalhe.</p>
      </div>
    </div>
  </section> -->
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>