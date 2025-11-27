<?php
// Função de segurança XSS
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
    display:block;
    border-radius:4px;
}
.table .actions a{
    font-weight:normal;
    display:inline-block;
    padding:3px 6px;
    background:#eee;
    color:#333;
    border-radius:4px;
    font-size:12px;
}
.error{
    background:#ffebeb;
    color:#990000;
}
.success{
    background:#e6ffe6;
    color:#008000;
}
.form-row{
    display:flex;
    gap:10px;
}
.field{
    flex:1;
}
.form-row .field:first-child{
    margin-right:10px;
}
label{
    font-weight:bold;
    display:block;
    margin-bottom:4px;
}
input[type=text], input[type=email], input[type=password], input[type=number], textarea, select{
    width:100%;
    padding:8px;
    box-sizing:border-box;
    border:1px solid #ddd;
    border-radius:4px;
}
.site-footer{
    background:#333;
    color:#fff;
    padding:10px 0;
    text-align:center;
    margin-top:20px;
}
.site-footer p{
    margin:0;
    font-size:14px;
}
</style>

</head>
<body>

<?php
// Exibe mensagens de erro ou sucesso armazenadas na sessão (se houver)
if(isset($_SESSION['error'])):
    echo '<div class="container"><div class="card error">'.h($_SESSION['error']).'</div></div>';
    unset($_SESSION['error']);
endif;
if(isset($_SESSION['success'])):
    echo '<div class="container"><div class="card success">'.h($_SESSION['success']).'</div></div>';
    unset($_SESSION['success']);
endif;
?>

<header>
  <div class="menu">
    <a href="index.php">Início</a>
   <a href="index.php">Imóveis</a>
    <a href="imovel_add.php" class="btn-new">Novo Imóvel</a>
    
    <?php if (isset($_SESSION['usuario_id'])): ?>
        <a href="logout.php">Sair</a>
    <?php endif; ?>
    
  </div>
</header>
<div class="container">
<main>