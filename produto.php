<?php
require_once __DIR__ . '/config/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die('Produto não encontrado.');
}

/* BUSCA TODAS AS IMAGENS DO PRODUTO */
$stmtImagens = $pdo->prepare("SELECT * FROM produto_imagens WHERE produto_id = ?");
$stmtImagens->execute([$id]);
$imagens = $stmtImagens->fetchAll(PDO::FETCH_ASSOC);

$titulo = $produto['nome'] . ' | Ferla Estofados';
include __DIR__ . '/includes/header.php';
?>

<link rel="stylesheet" href="/estofadosferla/style.css">

<main class="product-page">
    <div class="container">
        <a href="/estofadosferla/index.php#produtos" class="back-link">← Voltar aos produtos</a>

        <section class="product-layout">
            <div class="product-gallery">
                <div class="product-image-box">
                    <img id="imagem-principal"
                         src="<?= htmlspecialchars(!empty($imagens) ? $imagens[0]['caminho'] : $produto['imagem']) ?>"
                         alt="<?= htmlspecialchars($produto['nome']) ?>">
                </div>

                <?php if (!empty($imagens)): ?>
                    <div class="product-thumbs">
                        <?php foreach ($imagens as $img): ?>
                            <img
                                src="<?= htmlspecialchars($img['caminho']) ?>"
                                alt="<?= htmlspecialchars($produto['nome']) ?>"
                                onclick="trocarImagem('<?= htmlspecialchars($img['caminho'], ENT_QUOTES) ?>')"
                            >
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
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

                    <a class="whatsapp-btn" target="_blank"
                        href="https://wa.me/554598175947?text=<?= urlencode('Olá, tenho interesse no produto ' . $produto['nome']) ?>">
                        COMPRE AQUI
                    </a>
                </div>
            </div>
        </section>
    </div>
</main>

<script>
function trocarImagem(src) {
    document.getElementById('imagem-principal').src = src;
}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>