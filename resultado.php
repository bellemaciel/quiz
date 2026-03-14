<?php
include 'config/connect.php';

// 1. Verifica se há uma pontuação na sessão (indispensável para estar nesta página)
if (!isset($_SESSION['score'])) {
    header('Location: index.php');
    exit;
}

$acertos = $_SESSION['score'];
$total = isset($_SESSION['total_perguntas']) ? $_SESSION['total_perguntas'] : 0;
$logado = isset($_SESSION['usuario_id']);
$nome_exibicao = $logado ? $_SESSION['usuario_nome'] : "Jogador";

// 2. Lógica para salvar automaticamente se o usuário estiver LOGADO
if ($logado && !isset($_SESSION['pontuacao_salva'])) {
    try {
        $sql = "INSERT INTO ranking (usuario_id, nome_usuario, pontuacao) VALUES (:uid, :nome, :pontos)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':uid'   => $_SESSION['usuario_id'],
            ':nome'  => $_SESSION['usuario_nome'],
            ':pontos' => $acertos
        ]);
        $_SESSION['pontuacao_salva'] = true;
    } catch (PDOException $e) {
        $erro_salvamento = "Erro ao salvar: " . $e->getMessage();
    }
}

// 3. Lógica para salvar se for CONVIDADO (via formulário POST)
if (!$logado && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome_convidado'])) {
    $nome_convidado = htmlspecialchars(trim($_POST['nome_convidado']));
    if (!empty($nome_convidado)) {
        try {
            // No banco, usuario_id fica como NULL para convidados
            $sql = "INSERT INTO ranking (usuario_id, nome_usuario, pontuacao) VALUES (NULL, :nome, :pontos)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':nome'  => $nome_convidado,
                ':pontos' => $acertos
            ]);
            $_SESSION['pontuacao_salva'] = true;
            $nome_exibicao = $nome_convidado; // Atualiza o nome na tela
        } catch (PDOException $e) {
            $erro_salvamento = "Erro: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>QZPLAY - Resultado Final</title>
    <link rel="stylesheet" href="css/style.css?v=7.0">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <style>
        .result-card { padding: 40px 20px; }
        .score-circle {
            width: 120px; height: 120px;
            background: var(--primary); color: white;
            border-radius: 50%; display: flex;
            align-items: center; justify-content: center;
            font-size: 2.5rem; font-weight: bold;
            margin: 20px auto; border: 8px solid var(--secondary);
        }
        .guest-form {
            background: #f8f9ff;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            border: 1px solid #e0e0e0;
        }
        .input-guest {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

    <div class="container animate-in result-card">
        <h1>Parabéns, <?= explode(' ', $nome_exibicao)[0] ?>! 🥳</h1>
        <p>Você concluiu o desafio. Confira seu desempenho:</p>

        <div class="score-circle">
            <?= $acertos ?>
        </div>

        <?php if (isset($_SESSION['pontuacao_salva'])): ?>
            <p style="color: #2ecc71; font-weight: bold;">✅ Pontuação registrada no ranking!</p>
        <?php endif; ?>

        <?php if (!$logado && !isset($_SESSION['pontuacao_salva'])): ?>
            <div class="guest-form">
                <p style="font-size: 0.9rem; margin-bottom: 10px;">Deseja salvar seu nome no ranking?</p>
                <form method="POST">
                    <input type="text" name="nome_convidado" class="input-guest" placeholder="Digite seu nome..." required>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">SALVAR NO RANKING</button>
                </form>
            </div>
        <?php endif; ?>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">

        <div style="display: flex; flex-direction: column; gap: 10px;">
            <a href="index.php" class="btn btn-primary" onclick="<?php unset($_SESSION['score'], $_SESSION['pontuacao_salva']); ?>">JOGAR NOVAMENTE</a>
            <a href="ranking.php" class="btn btn-ranking">VER RANKING GERAL</a>
        </div>
    </div>

    <script>
        window.onload = function() {
            var duration = 4 * 1000;
            var end = Date.now() + duration;
            (function frame() {
                confetti({
                    particleCount: 3,
                    angle: 60,
                    spread: 55,
                    origin: { x: 0 },
                    colors: ['#6c5ce7', '#a29bfe', '#00b894']
                });
                confetti({
                    particleCount: 3,
                    angle: 120,
                    spread: 55,
                    origin: { x: 1 },
                    colors: ['#6c5ce7', '#a29bfe', '#00b894']
                });
                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
            }());
        };
    </script>
</body>
</html>