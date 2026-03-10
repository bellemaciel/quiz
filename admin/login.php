<?php
include '../config/connect.php';


if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    
    $sql = "SELECT * FROM admins WHERE usuario = :usuario AND senha = :senha";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':usuario' => $usuario, ':senha' => $senha]);
    $admin = $stmt->fetch();

    if ($admin) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_nome'] = $admin['usuario'];
        header('Location: index.php'); 
        exit;
    } else {
        $erro = "Usuário ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo - QZPLAY</title>
    <link rel="stylesheet" href="../css/style.css?v=1.0">
    <style>
        
        .login-card {
            max-width: 400px;
            margin: 0 auto;
        }

        .admin-badge {
            background: #f8f9ff;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 20px;
            border: 2px solid var(--primary);
        }

        .error-message {
            background: #fff0f0;
            color: var(--danger);
            padding: 12px;
            border-radius: 8px;
            border-left: 4px solid var(--danger);
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: left;
        }

        .input-group {
            text-align: left;
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #636e72;
            font-size: 0.9rem;
        }

        .input-field {
            width: 100%;
            padding: 12px 15px;
            border-radius: 10px;
            border: 2px solid #dfe6e9;
            box-sizing: border-box;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.1);
        }

        .btn-login {
            width: 100%;
            margin-top: 10px;
            padding: 14px;
            font-size: 1rem;
            letter-spacing: 1px;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            color: #b2bec3;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>

    <div class="container animate-in login-card">
        <div class="admin-badge">🔐</div>
        <h1>Área Restrita</h1>
        <p style="color: #636e72; margin-bottom: 25px;">Entre com suas credenciais para gerenciar o QZPLAY.</p>

        <?php if(isset($erro)): ?>
            <div class="error-message animate-in">
                ⚠️ <strong>Erro:</strong> <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <label for="usuario">Usuário</label>
                <input type="text" name="usuario" id="usuario" class="input-field" placeholder="Seu nome de usuário" required autofocus>
            </div>

            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" class="input-field" placeholder="Sua senha secreta" required>
            </div>

            <button type="submit" class="btn btn-primary btn-login">
                ENTRAR NO PAINEL
            </button>
        </form>

        <a href="../index.php" class="back-link">← Voltar para a Página Inicial</a>
    </div>

</body>
</html>