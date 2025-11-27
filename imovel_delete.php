<?php
 require 'auth.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT imagem FROM imoveis WHERE id = :id");
$stmt->execute([':id'=>$id]);
$img = $stmt->fetchColumn();

$stmt = $pdo->prepare("DELETE FROM imoveis WHERE id = :id");
$stmt->execute([':id'=>$id]);

if ($img && file_exists('uploads/'.$img)) @unlink('uploads/'.$img);

$_SESSION['success'] = 'Imóvel apagado.';
header('Location: index.php');
exit;
