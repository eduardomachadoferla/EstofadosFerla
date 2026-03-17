<?php if (!isset($titulo)) $titulo = 'Ferla Estofados'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($titulo) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/style.css">
</head>
<body>
<header class="topbar">
  <div class="container navbar">
    <a href="/index.php" class="logo">
      <strong>FERLA</strong>
      <span>ESTOFADOS</span>
    </a>

    <ul class="menu">
      <li><a href="/index.php#inicio">Início</a></li>
<li class="dropdown">
  <a href="#">Todos os Produtos ▾</a>
  <ul class="dropdown-menu">
    <li><a href="/estofadosferla/index.php#sofas">Sofás</a></li>
    <li><a href="/estofadosferla/index.php#poltronas">Poltronas</a></li>
    <li><a href="/estofadosferla/index.php#cadeiras">Cadeiras</a></li>
    <li><a href="/estofadosferla/index.php#cabeceiras">Cabeceiras</a></li>
  </ul>
</li>
</li>
      <li><a href="/index.php#sobre">Sobre Nós</a></li>
    </ul>
  </div>
</header>