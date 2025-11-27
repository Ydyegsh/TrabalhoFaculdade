<?php
 require 'auth.php';

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$titulo = trim($_POST['titulo'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');
$cidade = trim($_POST['cidade'] ?? '');
$estado = trim($_POST['estado'] ?? '');
$tipo = $_POST['tipo'] ?? 'Outro';
$area_m2 = $_POST['area_m2'] !== '' ? (float)$_POST['area_m2'] : null;
$quartos = $_POST['quartos'] !== '' ? (int)$_POST['quartos'] : null;
$valor = $_POST['valor'] !== '' ? (float)$_POST['valor'] : null;

$imagem_nome = null;

// Upload de imagem
if (!empty($_FILES['imagem']) && $_FILES['imagem']['error'] !== UPLOAD_ERR_NO_FILE) {
    $f = $_FILES['imagem'];
    if ($f['error'] === UPLOAD_ERR_OK) {

        $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
        $allowed = ['png', 'jpg', 'jpeg', 'gif'];

        if (!in_array($ext, $allowed)) {
            $_SESSION['error'] = 'Formato de imagem não permitido.';
            header('Location: imovel_add.php' . ($id ? '?id='.$id : ''));
            exit;
        }

        $novo = bin2hex(random_bytes(8)) . '.' . $ext;

        if (!is_dir('uploads')) mkdir('uploads', 0755, true);

        if (!move_uploaded_file($f['tmp_name'], 'uploads/' . $novo)) {
            $_SESSION['error'] = 'Falha ao salvar a imagem.';
            header('Location: imovel_add.php' . ($id ? '?id='.$id : ''));
            exit;
        }

        $imagem_nome = $novo;
    }
}

try {
    if ($id) {
        // -----------------------------------
        // 🟦 Atualizar imóvel existente
        // -----------------------------------

        if ($imagem_nome) {
            // Atualiza também a imagem
            $sql = "UPDATE imoveis SET
                titulo=:titulo,
                descricao=:descricao,
                endereco=:endereco,
                cidade=:cidade,
                estado=:estado,
                tipo=:tipo,
                area_m2=:area_m2,
                quartos=:quartos,
                valor=:valor,
                imagem=:imagem
                WHERE id=:id";
        } else {
            // Atualiza sem modificar a imagem
            $sql = "UPDATE imoveis SET
                titulo=:titulo,
                descricao=:descricao,
                endereco=:endereco,
                cidade=:cidade,
                estado=:estado,
                tipo=:tipo,
                area_m2=:area_m2,
                quartos=:quartos,
                valor=:valor
                WHERE id=:id";
        }

        $stmt = $pdo->prepare($sql);

        $params = [
            ':titulo'=>$titulo,
            ':descricao'=>$descricao,
            ':endereco'=>$endereco,
            ':cidade'=>$cidade,
            ':estado'=>$estado,
            ':tipo'=>$tipo,
            ':area_m2'=>$area_m2,
            ':quartos'=>$quartos,
            ':valor'=>$valor,
            ':id'=>$id
        ];

        if ($imagem_nome) {
            $params[':imagem'] = $imagem_nome;
        }

        $stmt->execute($params);

        $_SESSION['success'] = 'Imóvel atualizado.';
    
    } else {

        // -----------------------------------
        // 🟥 Limite de 3 imóveis
        // -----------------------------------
        $stmt = $pdo->query("SELECT COUNT(*) FROM imoveis");
        $total = (int)$stmt->fetchColumn();

        if ($total >= 3) {
            $_SESSION['error'] = 'Limite máximo de 3 imóveis atingido.';
            header('Location: imovel_add.php');
            exit;
        }

        // -----------------------------------
        // 🟩 Inserir novo imóvel
        // -----------------------------------
        $stmt = $pdo->prepare("INSERT INTO imoveis 
            (titulo, descricao, endereco, cidade, estado, tipo, area_m2, quartos, valor, imagem)
            VALUES
            (:titulo,:descricao,:endereco,:cidade,:estado,:tipo,:area_m2,:quartos,:valor,:imagem)");

        $stmt->execute([
            ':titulo'=>$titulo,
            ':descricao'=>$descricao,
            ':endereco'=>$endereco,
            ':cidade'=>$cidade,
            ':estado'=>$estado,
            ':tipo'=>$tipo,
            ':area_m2'=>$area_m2,
            ':quartos'=>$quartos,
            ':valor'=>$valor,
            ':imagem'=>$imagem_nome
        ]);

        $_SESSION['success'] = 'Imóvel cadastrado.';
    }

} catch (Exception $e) {
    $_SESSION['error'] = 'Erro ao salvar: '.$e->getMessage();
}

header('Location: index.php');
exit;

