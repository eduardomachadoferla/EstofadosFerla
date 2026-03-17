<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/db.php';
exigir_login();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header('Location: /estofadosferla/admin/index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    header('Location: /estofadosferla/admin/index.php');
    exit;
}

/* remove a imagem do servidor, se existir */
$caminhoImagem = $produto['imagem'] ?? '';

if (!empty($caminhoImagem)) {
    $caminhoImagem = str_replace('/estofadosferla/', '', $caminhoImagem);
    $arquivoFisico = dirname(__DIR__) . '/' . $caminhoImagem;

    if (file_exists($arquivoFisico) && is_file($arquivoFisico)) {
        unlink($arquivoFisico);
    }
}

/* remove o produto do banco */
$stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
$stmt->execute([$id]);

header('Location: /estofadosferla/admin/index.php');
exit;