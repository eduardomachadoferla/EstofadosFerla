<?php
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../config/db.php';
exigir_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /estofadosferla/admin/index.php');
    exit;
}

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
$categoria = trim($_POST['categoria'] ?? '');
$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$preco = trim($_POST['preco'] ?? '');
$imagemAtual = trim($_POST['imagem_atual'] ?? '');

if ($id <= 0 || $categoria === '' || $nome === '' || $descricao === '' || $preco === '') {
    die('Preencha todos os campos obrigatórios.');
}

$imagemFinal = $imagemAtual;

if (!empty($_FILES['imagem']['name'])) {
    $baseDir   = dirname(__DIR__);
    $assetsDir = $baseDir . DIRECTORY_SEPARATOR . 'assets';
    $uploadDir = $assetsDir . DIRECTORY_SEPARATOR . 'uploads';

    if (!file_exists($assetsDir)) {
        mkdir($assetsDir, 0777, true);
    }

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($ext, $permitidas, true)) {
        die('Formato inválido. Use jpg, jpeg, png ou webp.');
    }

    $nomeArquivo = uniqid('produto_', true) . '.' . $ext;
    $destino = $uploadDir . DIRECTORY_SEPARATOR . $nomeArquivo;

    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
        die('Erro ao enviar a nova imagem.');
    }

    $imagemFinal = '/estofadosferla/assets/uploads/' . $nomeArquivo;
}

$stmt = $pdo->prepare("
    UPDATE produtos
    SET categoria = ?, nome = ?, descricao = ?, preco = ?, imagem = ?
    WHERE id = ?
");
$stmt->execute([$categoria, $nome, $descricao, $preco, $imagemFinal, $id]);

header('Location: /estofadosferla/admin/index.php');
exit;