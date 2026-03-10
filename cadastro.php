<?php
include 'config/connect.php';

$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome  = htmlspecialchars(trim($_POST['nome']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];

    
    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = "Por favor, preencha todos os campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "E-mail inválido.";
    } elseif ($senha !== $confirma_senha) {
        $erro = "As senhas não coincidem.";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres.";
    } else {
        try {
            
            $check = $conn->prepare("SELECT id FROM usuarios WHERE email = :email");
            $check->execute([':email' => $email]);
            
            if ($check->rowCount() > 0) {
                $erro = "Este e-mail já está cadastrado.";
            } else {
                
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                
                $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':nome'  => $nome,
                    ':email' => $email,
                    ':senha' => $senha_hash
                ]);

                $sucesso = "Conta criada com sucesso! Redirecionando...";
                header("refresh:2;url=login_jogador.php");
            }
        } catch (PDOException $e) {
            $erro = "Erro ao cadastrar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QZPLAY - Criar Conta</title>
    <link rel="stylesheet" href="css/style.css?v=6.0">
    <style>
        .input-group { text-align: left; margin-bottom: 15px; width: 100%; }
        .input-group label { display: block; font-weight: bold; margin-bottom: 5px; color: #636e72; font-size: 0.9rem; }
        .input-field { width: 100%; padding: 12px; border-radius: 10px; border: 2px solid #dfe6e9; box-sizing: border-box; }
        .input-field:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.1); }
        .msg { padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 0.9rem; }
        .msg-erro { background: #fff0f0; color: var(--danger); border-left: 4px solid var(--danger); }
        .msg-sucesso { background: #e6fffa; color: var(--success); border-left: 4px solid var(--success); }
    </style>
</head>
<body>

    <div class="container animate-in">
        <h1 style="margin-bottom: 10px;">Criar Conta 🚀</h1>
        <p style="color: #636e72; margin-bottom: 25px;">Junte-se ao QZPLAY e salve seu progresso!</p>

        <?php if($erro): ?>
            <div class="msg msg-erro animate-in"><?= $erro ?></div>
        <?php endif; ?>

        <?php if($sucesso): ?>
            <div class="msg msg-sucesso animate-in"><?= $sucesso ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="input-group">
                <label for="nome">Nome de Jogador</label>
                <input type="text" name="nome" id="nome" class="input-field" placeholder="Como quer ser chamado?" required value="<?= isset($nome) ? $nome : '' ?>">
            </div>

            <div class="input-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="input-field" placeholder="seu@email.com" required value="<?= isset($email) ? $email : '' ?>">
            </div>

            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" class="input-field" placeholder="Mínimo 6 caracteres" required>
            </div>

            <div class="input-group">
                <label for="confirma_senha">Confirmar Senha</label>
                <input type="password" name="confirma_senha" id="confirma_senha" class="input-field" placeholder="Repita a senha" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">CADASTRAR</button>
        </form>

        <p style="margin-top: 20px; font-size: 0.9rem;">
            Já tem uma conta? <a href="login_jogador.php" style="color: var(--primary); font-weight: bold; text-decoration: none;">Faça Login</a>
        </p>
    </div>

</body>
</html>