<?php
// auth.php
include 'config2.php'; // Inclui a conexão e a função h() (se estiver em header.php)

// Se o usuário não estiver logado, redireciona para a página de login
if (!isset($_SESSION['usuario_id'])) {
    // Redireciona o usuário para login.php
    header('Location: login.php');
    exit;
}

// Opcional: Se precisar de informações do usuário logado (ex: nome, email)
$usuario_logado = null;
try {
    $stmt = $pdo->prepare("SELECT id, email FROM usuarios WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['usuario_id']]);
    $usuario_logado = $stmt->fetch();

    if (!$usuario_logado) {
        // Se a sessão for inválida, destrói e redireciona
        session_destroy();
        header('Location: login.php');
        exit;
    }
} catch (Exception $e) {
    // Em caso de erro do banco de dados, trate de forma segura
    session_destroy();
    header('Location: login.php');
    exit;
}
?>