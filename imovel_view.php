<?php
 require 'auth.php';
require 'header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) { echo '<div class="card error">ID inválido</div>'; require 'footer.php'; exit; }

$stmt = $pdo->prepare("SELECT * FROM imoveis WHERE id = :id");
$stmt->execute([':id'=>$id]);
$im = $stmt->fetch();
if (!$im) { echo '<div class="card error">Imóvel não encontrado</div>'; require 'footer.php'; exit; }
?>
<div class="card">
  <h2><?=h($im['titulo'])?></h2>
  <?php if ($im['imagem'] && file_exists('uploads/'.$im['imagem'])): ?>
    <img src="uploads/<?=h($im['imagem'])?>" style="max-width:320px;display:block;margin-bottom:12px" alt="">
  <?php endif; ?>

  <p><strong>Tipo:</strong> <?=h($im['tipo'])?></p>
  <p><strong>Endereço:</strong> <?=h($im['endereco'])?> — <?=h($im['cidade'])?> / <?=h($im['estado'])?></p>
  <p><strong>Área:</strong> <?= $im['area_m2'] ?: '-' ?> m²</p>
  <p><strong>Quartos:</strong> <?= $im['quartos'] ?: '-' ?></p>
  <p><strong>Valor:</strong> <?= $im['valor'] ? 'R$ '.number_format($im['valor'],2,',','.') : '-' ?></p>
  <h3>Descrição</h3>
  <p><?= nl2br(h($im['descricao'])) ?></p>

  <div style="margin-top:12px">
    <a href="imovel_add.php?id=<?= $im['id'] ?>">Editar</a>
    <a href="imovel_delete.php?id=<?= $im['id'] ?>" onclick="return confirm('Apagar este imóvel?')">Apagar</a>
    <a href="index.php" style="margin-left:12px">Voltar</a>
  </div>
</div>

<?php require 'footer.php'; ?>
