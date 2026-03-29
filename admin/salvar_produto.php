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

/* agora valida o array de imagens */
if (
    empty($categoria) ||
    empty($nome) ||
    empty($descricao) ||
    empty($preco) ||
    empty($_FILES['imagens']['name'][0])
) {
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

$extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
$imagensSalvas = [];

/* faz upload de todas as imagens */
foreach ($_FILES['imagens']['name'] as $i => $nomeOriginal) {
    if ($_FILES['imagens']['error'][$i] !== 0) {
        continue;
    }

    $ext = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

    if (!in_array($ext, $extensoesPermitidas)) {
        die('Formato de imagem inválido. Use jpg, jpeg, png ou webp.');
    }

    $nomeArquivo = uniqid('produto_', true) . '.' . $ext;
    $destino = $uploadDir . DIRECTORY_SEPARATOR . $nomeArquivo;

    if (!move_uploaded_file($_FILES['imagens']['tmp_name'][$i], $destino)) {
        die('Erro ao enviar imagem.');
    }

    $caminhoImagem = '/estofadosferla/assets/uploads/' . $nomeArquivo;
    $imagensSalvas[] = $caminhoImagem;
}

if (empty($imagensSalvas)) {
    die('Erro ao enviar as imagens.');
}

/* primeira imagem vira imagem principal */
$imagemPrincipal = $imagensSalvas[0];

/* salva o produto */
$stmt = $pdo->prepare("
    INSERT INTO produtos (categoria, nome, descricao, preco, imagem)
    VALUES (?, ?, ?, ?, ?)
");
$stmt->execute([$categoria, $nome, $descricao, $preco, $imagemPrincipal]);

$produtoId = $pdo->lastInsertId();

/* salva todas as imagens na tabela produto_imagens */
$stmtImg = $pdo->prepare("
    INSERT INTO produto_imagens (produto_id, caminho)
    VALUES (?, ?)
");

foreach ($imagensSalvas as $caminho) {
    $stmtImg->execute([$produtoId, $caminho]);
}

header('Location: /estofadosferla/admin/index.php');
exit;