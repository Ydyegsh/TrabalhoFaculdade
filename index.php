<?php
include 'config2.php';
require 'header.php';

$search = $_GET['q'] ?? '';
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 8;
$offset = ($page - 1) * $perPage;

$where = '1';
$params = [];

if ($search !== '') {
    $where = "(titulo LIKE :q OR endereco LIKE :q OR cidade LIKE :q)";
    $params[':q'] = "%$search%";
}

// total
$stmt = $pdo->prepare("SELECT COUNT(*) FROM imoveis WHERE {$where}");
$stmt->execute($params);
$total = (int)$stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT * FROM imoveis WHERE {$where} ORDER BY id DESC LIMIT :lim OFFSET :off");
foreach ($params as $k=>$v) $stmt->bindValue($k,$v);
$stmt->bindValue(':lim', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':off', $offset, PDO::PARAM_INT);
$stmt->execute();
$imoveis = $stmt->fetchAll();
?>
<div class="card">
  <form method="get" style="display:flex;gap:8px;align-items:center">
    <input type="text" name="q" placeholder="Buscar por título, cidade ou endereço" value="<?=h($search)?>">
    <button type="submit">Buscar</button>
  </form>
</div>

<div class="card">
  <table class="table">
    <thead>
      <tr>
        <th>Imagem</th>
        <th>Título</th>
        <th>Tipo / Cidade</th>
        <th>Área (m²)</th>
        <th>Valor (R$)</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
    <?php if (!$imoveis): ?>
      <tr><td colspan="6">Nenhum imóvel encontrado.</td></tr>
    <?php else: foreach($imoveis as $im): ?>
      <tr>
        <td><?php if ($im['imagem'] && file_exists('uploads/'.$im['imagem'])): ?>
            <img src="uploads/<?=h($im['imagem'])?>" alt="" class="thumb">
          <?php else: ?>
            <img src="https://via.placeholder.com/110x80?text=Sem+Foto" class="thumb" alt="">
          <?php endif; ?>
        </td>
        <td><?=h($im['titulo'])?></td>
        <td><?=h($im['tipo'])?> — <?=h($im['cidade'])?></td>
        <td><?= $im['area_m2'] ? h($im['area_m2']) : '-' ?></td>
        <td><?= $im['valor'] ? number_format($im['valor'],2,',','.') : '-' ?></td>
        <td class="actions">
          <a href="imovel_view.php?id=<?= $im['id'] ?>">Ver</a>
          <a href="imovel_add.php?id=<?= $im['id'] ?>">Editar</a>
          <a href="imovel_delete.php?id=<?= $im['id'] ?>" onclick="return confirm('Apagar este imóvel?')">Apagar</a>
        </td>
      </tr>
    <?php endforeach; endif;?>
    </tbody>
  </table>

  <?php
  $pages = (int)ceil($total / $perPage);
  if ($pages > 1): ?>
    <div style="margin-top:12px">
      <?php for($i=1;$i<=$pages;$i++): ?>
        <a href="?q=<?=urlencode($search)?>&page=<?=$i?>" style="margin-right:6px;<?php if($i== $page) echo 'font-weight:700'?>"><?= $i ?></a>
      <?php endfor; ?>
    </div>
  <?php endif; ?>

</div>

<?php require 'footer.php'; ?>
