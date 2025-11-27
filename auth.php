<?php
include 'config2.php';

if (!isset($_SESSION['usuario_id'])) 
    header('Location: login.php');
    exit;
}

$usuario_logado = null;
try {
    $stmt = $pdo->prepare("SELECT id, email FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['usuario_id']]);
    $usuario_logado = $stmt->fetch();

    if (!$usuario_logado) {
        session_destroy();
        header('Location: login.php');
        exit;
    }
} catch (Exception $e) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
