<?php
require_once __DIR__ . '/config/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die('Produto não encontrado.');
}

$titulo = $produto['nome'] . ' | Ferla Estofados';
include __DIR__ . '/includes/header.php';
?>

<link rel="stylesheet" href="/estofadosferla/style.css">

<main class="product-page">
  <div class="container">
    <a href="/estofadosferla/index.php#produtos" class="back-link">← Voltar aos produtos</a>

    <section class="product-layout">
      <div class="product-image-box">
        <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
      </div>

      <div class="product-info">
        <span class="product-category"><?= htmlspecialchars($produto['categoria']) ?></span>
        <h1><?= htmlspecialchars($produto['nome']) ?></h1>

        <p class="product-description">
          <?= nl2br(htmlspecialchars($produto['descricao'])) ?>
        </p>

        <div class="specs">
          <h3>ESPECIFICAÇÕES</h3>
          <ul>
            <li>Categoria: <?= htmlspecialchars($produto['categoria']) ?></li>
            <li>Nome do produto: <?= htmlspecialchars($produto['nome']) ?></li>
            <li>Preço: <?= htmlspecialchars($produto['preco']) ?></li>
            <li>Referência: PROD-<?= str_pad($produto['id'], 4, '0', STR_PAD_LEFT) ?></li>
          </ul>
        </div>

        <div class="buy-box">
          <div class="price-line"></div>
          <div class="product-price"><?= htmlspecialchars($produto['preco']) ?></div>
          <a
            class="whatsapp-btn"
            target="_blank"
            href="https://wa.me/5500000000000?text=Olá, tenho interesse no produto <?= urlencode($produto['nome']) ?>">
            COMPRAR PELO WHATSAPP
          </a>
        </div>
      </div>
    </section>
  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>