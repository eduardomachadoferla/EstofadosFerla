<?php
require_once __DIR__ . '/config/db.php';
$titulo = 'Ferla Estofados';

$stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC");
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
        <h2>Destaques</h2>
        <p>Peças selecionadas para você</p>
      </div>

      <div class="products-grid">
        <?php
        $sofasMarcado = false;
        $poltronasMarcado = false;
        $cadeirasMarcado = false;
        $cabeceirasMarcado = false;
        ?>

        <?php foreach ($produtos as $produto): ?>
          <?php $categoria = mb_strtolower(trim($produto['categoria']), 'UTF-8'); ?>

          <?php if (!$sofasMarcado && ($categoria === 'sofas' || $categoria === 'sofás')): ?>
            <div id="sofas" class="anchor"></div>
            <?php $sofasMarcado = true; ?>
          <?php endif; ?>

          <?php if (!$poltronasMarcado && ($categoria === 'poltronas' || $categoria === 'poltrona')): ?>
            <div id="poltronas" class="anchor"></div>
            <?php $poltronasMarcado = true; ?>
          <?php endif; ?>

          <?php if (!$cadeirasMarcado && ($categoria === 'cadeiras' || $categoria === 'cadeira')): ?>
            <div id="cadeiras" class="anchor"></div>
            <?php $cadeirasMarcado = true; ?>
          <?php endif; ?>

          <?php if (!$cabeceirasMarcado && ($categoria === 'cabeceiras' || $categoria === 'cabeceira')): ?>
            <div id="cabeceiras" class="anchor"></div>
            <?php $cabeceirasMarcado = true; ?>
          <?php endif; ?>

          <article class="card">
            <div class="card-image">
              <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
            </div>

            <div class="card-body">
              <span class="tag"><?= htmlspecialchars($produto['categoria']) ?></span>
              <h3><?= htmlspecialchars($produto['nome']) ?></h3>
              <p><?= htmlspecialchars($produto['descricao']) ?></p>

              <div class="card-footer">
                <strong class="price"><?= htmlspecialchars($produto['preco']) ?></strong>
                <a class="outline-btn" href="/estofadosferla/produto.php?id=<?= $produto['id'] ?>">Saber mais</a>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="categories" id="sobre">
    <div class="container">
      <div class="section-header">
        <h2>Sobre Nós</h2>
        <p>Elegância, conforto e qualidade em cada detalhe.</p>
      </div>
    </div>
  </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>