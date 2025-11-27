<?php
// logout.php
session_start();
session_destroy(); // Destrói todos os dados da sessão
header('Location: login.php'); // Redireciona para a página de login
exit;
?>