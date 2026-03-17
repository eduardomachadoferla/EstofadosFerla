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

<main class="product-page">
  <div class="container">
    <a href="/index.php#produtos" class="back-link">← Voltar aos produtos</a>

    <section class="product-layout">
      <div class="product-image-box">
        <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
      </div>

      <div class="product-info">
        <span class="product-category"><?= htmlspecialchars($produto['categoria']) ?></span>
        <h1><?= htmlspecialchars($produto['nome']) ?></h1>
        <p class="product-description"><?= htmlspecialchars($produto['descricao']) ?></p>

        <div class="buy-box">
          <div class="price-line"></div>
          <div class="product-price"><?= htmlspecialchars($produto['preco']) ?></div>
          <a class="whatsapp-btn" target="_blank" href="https://wa.me/5500000000000?text=Olá, tenho interesse no produto <?= urlencode($produto['nome']) ?>">
            COMPRAR PELO WHATSAPP
          </a>
        </div>
      </div>
    </section>
  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>