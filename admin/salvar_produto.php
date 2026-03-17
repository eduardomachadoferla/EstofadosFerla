<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/db.php';
exigir_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /estofadosferla/admin/index.php');
    exit;
}

$categoria = trim($_POST['categoria'] ?? '');
$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$preco = trim($_POST['preco'] ?? '');

if (empty($categoria) || empty($nome) || empty($descricao) || empty($preco) || empty($_FILES['imagem']['name'])) {
    die('Preencha todos os campos.');
}

$baseDir = realpath(__DIR__ . '/..');
$assetsDir = $baseDir . DIRECTORY_SEPARATOR . 'assets';
$uploadDir = $assetsDir . DIRECTORY_SEPARATOR . 'uploads';

if (!is_dir($assetsDir)) {
    mkdir($assetsDir, 0777, true);
}

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
$extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

if (!in_array($ext, $extensoesPermitidas)) {
    die('Formato de imagem inválido. Use jpg, jpeg, png ou webp.');
}

$nomeArquivo = uniqid('produto_', true) . '.' . $ext;
$destino = $uploadDir . DIRECTORY_SEPARATOR . $nomeArquivo;

if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
    die('Erro ao enviar imagem.');
}

$caminhoImagem = '/estofadosferla/assets/uploads/' . $nomeArquivo;

$stmt = $pdo->prepare("INSERT INTO produtos (categoria, nome, descricao, preco, imagem) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$categoria, $nome, $descricao, $preco, $caminhoImagem]);

header('Location: /estofadosferla/index.php');
exit;