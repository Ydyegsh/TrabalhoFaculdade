<?php
function h($s){ return htmlspecialchars($s, ENT_QUOTES,'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Sistema</title>

<style>
body{
    font-family: Arial, sans-serif;
    margin:0;
    background:#f1f1f1;
}
header{
    background:#4A148C;
    color:#fff;
    padding:15px;
}
header .menu{
    display:flex;
    gap:15px;
    align-items:center;
}
header a{
    color:#fff;
    text-decoration:none;
    font-weight:bold;
}
.btn-new{
    background:#fff;
    color:#4A148C;
    padding:6px 10px;
    border-radius:6px;
    font-weight:bold;
}
.container{
    max-width:900px;
    margin:15px auto;
}
.card{
    background:#fff;
    padding:15px;
    border-radius:8px;
    margin-bottom:15px;
}
.table{
    width:100%;
    border-collapse:collapse;
}
.table th, .table td{
    border-bottom:1px solid #ddd;
    padding:8px;
}
.thumb{
    width:110px;
    height:80px;
    object-fit:cover;
    border-radius:6px;
}
.actions a{
    margin-right:6px;
}
</style>

</head>
<body>
<header>
  <div class="menu">
    <a href="index.php">Início</a>
   <!-- <a href="usuarios.php">Usuários</a> -->
   <a href="index.php">Imóveis</a>

    <!-- ESTE É O BOTÃO QUE SUMIU -->
    <a href="imovel_add.php" class="btn-new">Novo Imóvel</a>
  </div>
</header>
<div class="container">
