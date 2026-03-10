<?php
include 'config/connect.php';


if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$erro = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    try {
        
        $sql = "SELECT id, nome, senha FROM usuarios WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            
            header('Location: index.php');
            exit;
        } else {
            $erro = "E-mail ou senha incorretos.";
        }
    } catch (PDOException $e) {
        $erro = "Erro no sistema: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QZPLAY - Login de Jogador</title>
    <link rel="stylesheet" href="css/style.css?v=6.1">
    <style>
        .input-group { text-align: left; margin-bottom: 20px; width: 100%; }
        .input-group label { display: block; font-weight: bold; margin-bottom: 8px; color: #636e72; }
        .input-field { width: 100%; padding: 12px; border-radius: 10px; border: 2px solid #dfe6e9; box-sizing: border-box; font-size: 1rem; }
        .input-field:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.1); }
        .error-msg { background: #fff0f0; color: var(--danger); padding: 12px; border-radius: 8px; border-left: 4px solid var(--danger); margin-bottom: 20px; font-size: 0.9rem; }
    </style>
</head>
<body>

    <div class="container animate-in">
        <div style="font-size: 40px; margin-bottom: 10px;">🎮</div>
        <h1>Entrar no QZPLAY</h1>
        <p style="color: #636e72; margin-bottom: 25px;">Faça login para salvar suas pontuações no ranking!</p>

        <?php if($erro): ?>
            <div class="error-msg animate-in"><?= $erro ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="input-group">
                <label for="email">Seu E-mail</label>
                <input type="email" name="email" id="email" class="input-field" placeholder="exemplo@email.com" required autofocus>
            </div>

            <div class="input-group">
                <label for="senha">Sua Senha</label>
                <input type="password" name="senha" id="senha" class="input-field" placeholder="Sua senha secreta" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 1rem;">
                LOGAR E JOGAR
            </button>
        </form>

        <p style="margin-top: 25px; font-size: 0.9rem; color: #636e72;">
            Ainda não tem conta? <a href="cadastro.php" style="color: var(--primary); font-weight: bold; text-decoration: none;">Cadastre-se grátis</a>
        </p>
        
        <a href="index.php" style="display: block; margin-top: 15px; font-size: 0.8rem; color: #b2bec3; text-decoration: none;">← Voltar ao início</a>
    </div>

</body>
</html>