<?php
require_once __DIR__ . '/config/db.php';

$sql = "CREATE TABLE IF NOT EXISTS produtos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    categoria TEXT NOT NULL,
    nome TEXT NOT NULL,
    descricao TEXT NOT NULL,
    preco TEXT NOT NULL,
    imagem TEXT NOT NULL,
    destaque INTEGER DEFAULT 1,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
)";
$sql2 = "CREATE TABLE IF NOT EXISTS produto_imagens (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    produto_id INTEGER,
    caminho TEXT
)";

$pdo->exec($sql2);
$pdo->exec($sql);

echo 'Banco e tabela criados com sucesso!';