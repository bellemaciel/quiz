<?php

include 'config/connect.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$stmt = null;

try {
    $sql = "SELECT id, nome, icone FROM temas WHERE id > 0";
    $stmt = $conn->query($sql);
} catch (PDOException $e) {
    $erro_sql = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>QZPLAY - Início</title>
    <link rel="stylesheet" href="css/style.css?v=4.0">

    <style>
        .themes-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin: 20px 0;
            list-style: none;
            padding: 0;
            width: 100%;
        }

        .theme-card {
            background: #ffffff;
            border: 2px solid #f0f2f5;
            border-radius: 15px;
            padding: 20px;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
            box-sizing: border-box;
            height: 100%;
        }

        .theme-card:hover {
            transform: translateY(-8px);
            border-color: var(--primary);
            box-shadow: 0 10px 20px rgba(108, 92, 231, 0.15);
        }

        .theme-icon-container {
            width: 70px;
            height: 70px;
            background: #f8f9ff;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            margin-bottom: 15px;
            transition: background 0.3s;
            overflow: hidden;
        }

        .theme-card:hover .theme-icon-container {
            background: var(--secondary);
        }

        .theme-icon-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .theme-name {
            font-weight: bold;
            font-size: 1rem;
            color: var(--primary);
            text-align: center;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .animate-in { animation: fadeInUp 0.8s ease forwards; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.3s; }
        .delay-3 { animation-delay: 0.5s; }
        .floating { animation: float 3s ease-in-out infinite; }

        .container {
            overflow: visible;
            padding-bottom: 30px;
        }

        
        .logout-link {
            color: var(--danger);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: bold;
            margin-top: 5px;
            display: inline-block;
        }
        .logout-link:hover { text-decoration: underline; }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="animate-in">Bem-vindo ao QZPLAY!</h1>

        <div class="animate-in" style="margin-bottom: 20px; text-align: center;">
            <?php if (isset($_SESSION['usuario_nome'])): ?>
                <p style="margin-bottom: 5px;">Olá, <strong><?= explode(' ', $_SESSION['usuario_nome'])[0] ?></strong>! Pronto para bater seu recorde?</p>
                <a href="logout.php" class="logout-link">[ ENCERRAR SESSÃO ]</a>
            <?php else: ?>
                <p>
                    <a href="login_jogador.php" style="color: var(--primary); font-weight: bold; text-decoration: none;">Faça login</a> 
                    ou 
                    <a href="cadastro.php" style="color: var(--primary); font-weight: bold; text-decoration: none;">crie uma conta</a> 
                    para salvar seus pontos!
                </p>
            <?php endif; ?>
        </div>

        <div class="animate-in delay-1 floating" style="margin-bottom: 30px; padding: 20px; border: 2px dashed var(--primary); border-radius: 12px; background: #f9f8ff; box-shadow: 0 5px 15px rgba(108, 92, 231, 0.1); width: 100%; box-sizing: border-box;">
            <h3 style="margin-top:0; text-align:center;">🔥 Desafio do Dia</h3>
            <p style="font-size: 0.9rem; color: #636e72; text-align:center;">Perguntas da API. Apenas uma tentativa por dia!</p>
            <a href="desafio.php" class="btn btn-primary" style="width: 100%; margin: 15px 0 0 0; text-align: center; display: block; box-sizing: border-box;">
                JOGAR AGORA
            </a>
        </div>

        <h2 class="animate-in delay-2" style="text-align:center;">Escolha um tema:</h2>

        <ul class="themes-grid animate-in delay-3">
            <?php
            if ($stmt && $stmt->rowCount() > 0) {
                while ($tema = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $icone_db = $tema['icone'];
                    $fallback_icon = "💡";
            ?>
                    <li>
                        <a href="quiz.php?tema_id=<?= $tema['id'] ?>&q=0" class="theme-card">
                            <div class="theme-icon-container">
                                <?php if ($icone_db && preg_match('/\.(png|jpg|jpeg|svg)$/i', $icone_db)): ?>
                                    <img src="img/temas/<?= htmlspecialchars($icone_db) ?>" alt="<?= htmlspecialchars($tema['nome']) ?>">
                                <?php elseif ($icone_db): ?>
                                    <?= htmlspecialchars($icone_db) ?>
                                <?php else: ?>
                                    <?= $fallback_icon ?>
                                <?php endif; ?>
                            </div>
                            <span class="theme-name"><?= htmlspecialchars($tema['nome']) ?></span>
                        </a>
                    </li>
            <?php
                }
            } else {
                echo '<li style="grid-column: span 2; text-align:center; color: #666;">';
                echo isset($erro_sql) ? "Erro no banco: " . $erro_sql : "Nenhum tema cadastrado.";
                echo '</li>';
            }
            ?>
        </ul>

        <hr class="animate-in delay-3" style="width: 100%; border: 0; border-top: 1px solid #eee; margin: 20px 0;">

        <a href="ranking.php" class="animate-in delay-3 btn btn-ranking" style="width: 100%; box-sizing: border-box; text-align: center; display: block;">🏆 Ver Ranking Geral</a>
    </div>

    <footer style="text-align: center; width: 100%; margin-top: 20px;">
        <p>© 2026 - QZPLAY Quiz Interativo</p>
        <a href="admin/login.php" style="color: rgba(12, 8, 8, 0.5); font-size: 10px; text-decoration: none; display: block;">
            Acesso Restrito
        </a>
    </footer>
</body>

</html>