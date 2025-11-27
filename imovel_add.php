<?php
 require 'auth.php';
require 'header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$imovel = [
  'titulo'=>'','descricao'=>'','endereco'=>'','cidade'=>'','estado'=>'','tipo'=>'Outro',
  'area_m2'=>'','quartos'=>'','valor'=>'','imagem'=>''
];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM imoveis WHERE id = :id");
    $stmt->execute([':id'=>$id]);
    $row = $stmt->fetch();
    if ($row) $imovel = $row;
    else { 
        echo '<div class="card error">Imóvel não encontrado.</div>'; 
        require 'footer.php'; 
        exit; 
    }
}
?>
<div class="card">
  <h2><?= $id ? 'Editar Imóvel' : 'Novo Imóvel' ?></h2>

  <form action="imovel_save.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=h($id)?>">

    <div class="form-row">
      <div class="field">
        <label>Título</label>
        <input type="text" name="titulo" required value="<?=h($imovel['titulo'])?>">
      </div>
      <div class="field">
        <label>Tipo</label>
        <select name="tipo">
          <?php $tipos=['Apartamento','Casa','Terreno','Comercial','Outro'];
          foreach($tipos as $t): ?>
            <option <?= $imovel['tipo']==$t ? 'selected' : '' ?>><?=h($t)?></option>
          <?php endforeach;?>
        </select>
      </div>
    </div>

    <div class="form-row" style="margin-top:10px">
      <div class="field">
        <label>Endereço</label>
        <input type="text" name="endereco" value="<?=h($imovel['endereco'])?>">
      </div>
      <div class="field">
        <label>Cidade</label>
        <input type="text" name="cidade" value="<?=h($imovel['cidade'])?>">
      </div>
      <div class="field">
        <label>Estado</label>
        <input type="text" name="estado" value="<?=h($imovel['estado'])?>">
      </div>
    </div>

    <div class="form-row" style="margin-top:10px">
      <div class="field">
        <label>Área (m²)</label>
        <input type="number" step="0.01" name="area_m2" value="<?=h($imovel['area_m2'])?>">
      </div>
      <div class="field">
        <label>Quartos</label>
        <input type="number" name="quartos" value="<?=h($imovel['quartos'])?>">
      </div>
      <div class="field">
        <label>Valor (R$)</label>
        <input type="number" step="0.01" name="valor" value="<?=h($imovel['valor'])?>">
      </div>
    </div>

    <div style="margin-top:10px">
      <label>Descrição</label>
      <textarea name="descricao" rows="5"><?=h($imovel['descricao'])?></textarea>
    </div>

    <div style="margin-top:10px">
      <label>Imagem (JPEG/PNG) — opcional</label>
      <?php if ($imovel['imagem'] && file_exists('uploads/'.$imovel['imagem'])): ?>
        <div style="margin-bottom:8px"><img src="uploads/<?=h($imovel['imagem'])?>" class="thumb" alt=""></div>
      <?php endif; ?>
      <input type="file" name="imagem">
    </div>

    <div style="margin-top:12px">
      <button type="submit">Salvar</button>
      <a href="index.php" style="margin-left:8px">Cancelar</a>
    </div>
  </form>
</div>

<?php require 'footer.php'; ?>
