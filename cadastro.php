<?php
// cadastro.php
include 'config2.php'; 
require 'header.php';

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirma_senha = $_POST['confirma_senha'] ?? '';

    if (empty($email) || empty($senha) || empty($confirma_senha)) {
        $erro = 'Todos os campos são obrigatórios.';
    } elseif ($senha !== $confirma_senha) {
        $erro = 'A senha e a confirmação de senha não são iguais.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } else {
        try {
            // 1. Verificar se o email já existe
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
            $stmt->execute([':email' => $email]);
            if ($stmt->fetchColumn() > 0) {
                $erro = 'Este email já está cadastrado.';
            } else {
                // 2. Criptografar a senha (ESSENCIAL PARA SEGURANÇA!)
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

                // 3. Inserir o novo usuário no banco de dados
                $stmt = $pdo->prepare("INSERT INTO usuarios (email, senha) VALUES (:email, :senha)");
                $stmt->execute([
                    ':email' => $email,
                    ':senha' => $senha_hash
                ]);

                $sucesso = 'Usuário cadastrado com sucesso! Você pode fazer login agora.';
                
                // Opcional: Redirecionar para o login após o sucesso
                // header('Location: login.php');
                // exit;
            }

        } catch (Exception $e) {
            $erro = 'Erro ao cadastrar: ' . $e->getMessage();
        }
    }
}
?>

<div class="card" style="max-width:350px; margin: 40px auto;">
  <h2>Cadastrar Novo Usuário</h2>

  <?php if ($sucesso): ?>
    <div style="color:green; margin-bottom: 10px; padding: 10px; border: 1px solid green; background: #e6ffe6; border-radius: 4px;">
      <?= h($sucesso) ?>
    </div>
  <?php endif; ?>

  <?php if ($erro): ?>
    <div style="color:red; margin-bottom: 10px; padding: 10px; border: 1px solid red; background: #ffebeb; border-radius: 4px;">
      <?= h($erro) ?>
    </div>
  <?php endif; ?>

  <form method="post" action="cadastro.php">
    <div style="margin-bottom:10px;">
      <label>Email</label>
      <input type="email" name="email" required value="<?= h($email ?? '') ?>" style="width: 100%; padding: 8px; box-sizing: border-box;">
    </div>
    <div style="margin-bottom:10px;">
      <label>Senha (mínimo 6 caracteres)</label>
      <input type="password" name="senha" required style="width: 100%; padding: 8px; box-sizing: border-box;">
    </div>
    <div style="margin-bottom:15px;">
      <label>Confirmar Senha</label>
      <input type="password" name="confirma_senha" required style="width: 100%; padding: 8px; box-sizing: border-box;">
    </div>
    <button type="submit" style="width: 100%; padding: 10px; background: #4A148C; color: white; border: none; border-radius: 4px; cursor: pointer;">Cadastrar</button>
  </form>
  <div style="margin-top: 15px; text-align: center;">
      Já tem conta? <a href="login.php">Fazer Login</a>
  </div>
</div>

<?php require 'footer.php'; ?>